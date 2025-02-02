<?php

namespace App\Controller;

use App\Enum\JobStatus;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/kanban')]
#[IsGranted('ROLE_USER')]
class KanbanController extends AbstractController
{
    #[Route('', name: 'app_kanban', methods: ['GET'])]
    public function index(JobOfferRepository $jobOfferRepository): Response
    {
            $jobs = $jobOfferRepository->findBy(['app_user' => $this->getUser()]);
            $kanbanData = [];
            
            foreach ($jobs as $job) {
                $status = $job->getStatus()->value;
                if (!isset($kanbanData[$status])) {
                    $kanbanData[$status] = [];
                }
                $kanbanData[$status][] = $job;
            }
        
            return $this->render('kanban/index.html.twig', [
                'kanban_data' => $kanbanData,
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