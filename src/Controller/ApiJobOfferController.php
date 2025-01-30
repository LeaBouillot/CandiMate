<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Enum\JobStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/job-offers')]
#[IsGranted('ROLE_USER')]
class ApiJobOfferController extends AbstractController
{
    #[Route('/update-status', name: 'api_job_offer_update_status', methods: ['POST'])]
    public function updateStatus(
        Request $request, 
        EntityManagerInterface $entityManager
    ): JsonResponse {
        try {
            // Décoder le corps de la requête JSON
            $data = json_decode($request->getContent(), true);

            // Valider les données requises
            if (!isset($data['jobOfferId']) || !isset($data['status'])) {
                return $this->json([
                    'success' => false,
                    'error' => 'Missing required fields: jobOfferId and status'
                ], 400);
            }

            // Récupérer l'offre
            $jobOffer = $entityManager->getRepository(JobOffer::class)->find($data['jobOfferId']);

            // Vérifier si l'offre existe
            if (!$jobOffer) {
                return $this->json([
                    'success' => false,
                    'error' => 'Job offer not found'
                ], 404);
            }

            // Vérifier que l'utilisateur est propriétaire de l'offre
            if ($jobOffer->getAppUser() !== $this->getUser()) {
                return $this->json([
                    'success' => false,
                    'error' => 'Access denied'
                ], 403);
            }

            // Valider et convertir le statut
            try {
                $newStatus = JobStatus::from($data['status']);
            } catch (\ValueError $e) {
                return $this->json([
                    'success' => false,
                    'error' => 'Invalid status value'
                ], 400);
            }

            // Mettre à jour le statut
            $oldStatus = $jobOffer->getStatus();
            $jobOffer->setStatus($newStatus);

            // Persister les changements
            $entityManager->flush();

            // Retourner la réponse
            return $this->json([
                'success' => true,
                'data' => [
                    'id' => $jobOffer->getId(),
                    'oldStatus' => $oldStatus->value,
                    'newStatus' => $newStatus->value,
                    'updatedAt' => $jobOffer->getUpdatedAt()->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'error' => 'An error occurred while updating the status'
            ], 500);
        }
    }
}