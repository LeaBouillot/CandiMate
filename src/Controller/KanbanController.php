<?php

namespace App\Controller;

use App\Enum\JobStatus;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/kanban')]
// #[IsGranted('ROLE_USER')]
class KanbanController extends AbstractController
{
    #[Route('', name: 'app_kanban', methods: ['GET'])]
    public function index(JobOfferRepository $jobOfferRepository): Response
    {
        $jobOffers = $jobOfferRepository->findBy(
            ['app_user' => $this->getUser()],
            ['applicationDate' => 'DESC']
        );

        // Organiser les offres par statut
        $columns = [];
        foreach (JobStatus::cases() as $status) {
            $columns[$status->value] = [
                'title' => $status->label(),
                'offers' => array_filter(
                    $jobOffers,
                    fn($offer) => $offer->getStatus() === $status
                ),
                // 'badge_class' => $this->getStatusBadgeClass($status),
                // 'border_class' => $this->getStatusBorderClass($status),
            ];
        }

        return $this->render('kanban/index.html.twig', [
            'columns' => $columns,
        ]);
    }

    private function getStatusBadgeClass(JobStatus $status): string
    {
        return match($status) {
            JobStatus::A_POSTULER => 'bg-primary',
            JobStatus::EN_ATTENTE => 'bg-warning',
            JobStatus::ENTRETIEN => 'bg-info',
            JobStatus::REFUSE => 'bg-danger',
            JobStatus::ACCEPTE => 'bg-success',
        };
    }
}