<?php

namespace App\Controller;

use App\Enum\JobStatus;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/dashboard')]
// #[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    #[Route('', name: 'app_dashboard', methods: ['GET'])]
    public function index(JobOfferRepository $jobOfferRepository): Response
    {
        $user = $this->getUser();
        $jobOffers = $jobOfferRepository->findBy(['app_user' => $user]);

        // Statistiques par statut
        $statsByStatus = [];
        foreach (JobStatus::cases() as $status) {
            $statsByStatus[$status->value] = array_filter(
                $jobOffers,
                fn($offer) => $offer->getStatus() === $status
            );
        }

        // Calcul du taux de conversion
        $totalApplications = count($jobOffers);
        $interviews = count($statsByStatus[JobStatus::ENTRETIEN->value]);
        $accepted = count($statsByStatus[JobStatus::ACCEPTE->value]);
        
        $interviewRate = $totalApplications > 0 
            ? round(($interviews / $totalApplications) * 100, 1) 
            : 0;
        
        $successRate = $totalApplications > 0 
            ? round(($accepted / $totalApplications) * 100, 1) 
            : 0;

        // Statistiques mensuelles
        $monthlyStats = [];
        foreach ($jobOffers as $offer) {
            $month = $offer->getApplicationDate()->format('Y-m');
            if (!isset($monthlyStats[$month])) {
                $monthlyStats[$month] = [
                    'total' => 0,
                    'interview' => 0,
                    'accepted' => 0
                ];
            }
            $monthlyStats[$month]['total']++;
            
            if ($offer->getStatus() === JobStatus::ENTRETIEN) {
                $monthlyStats[$month]['interview']++;
            }
            if ($offer->getStatus() === JobStatus::ACCEPTE) {
                $monthlyStats[$month]['accepted']++;
            }
        }
        // Trier par mois
        krsort($monthlyStats);

        // Récupérer les 5 dernières candidatures
        $recentApplications = array_slice(
            array_filter($jobOffers, fn($offer) => $offer->getApplicationDate() <= new \DateTime()),
            0,
            5
        );

        return $this->render('dashboard/index.html.twig', [
            'stats_by_status' => $statsByStatus,
            'monthly_stats' => $monthlyStats,
            'total_applications' => $totalApplications,
            'interview_rate' => $interviewRate,
            'success_rate' => $successRate,
            'recent_applications' => $recentApplications,
            'statuses' => JobStatus::cases(),
        ]);
    }
}