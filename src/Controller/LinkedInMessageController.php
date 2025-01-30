<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Entity\LinkedInMessage;
use App\Repository\LinkedInMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/linkedin-message')]
#[IsGranted('ROLE_USER')]
class LinkedInMessageController extends AbstractController
{
    #[Route('/generate', name: 'app_linkedin_message_generate', methods: ['POST'])]
    public function generate(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            
            if (!isset($data['jobOfferId'])) {
                return $this->json([
                    'error' => 'Job offer ID is required'
                ], Response::HTTP_BAD_REQUEST);
            }

            $jobOffer = $entityManager->getRepository(JobOffer::class)->find($data['jobOfferId']);
            
            if (!$jobOffer) {
                return $this->json([
                    'error' => 'Job offer not found'
                ], Response::HTTP_NOT_FOUND);
            }

            // Vérifier que l'utilisateur est propriétaire de l'offre
            if ($jobOffer->getAppUser() !== $this->getUser()) {
                return $this->json([
                    'error' => 'Access denied'
                ], Response::HTTP_FORBIDDEN);
            }

            // Générer le contenu du message LinkedIn
            $messageContent = $this->generateMessageContent($jobOffer);

            // Créer et sauvegarder le message
            $linkedInMessage = new LinkedInMessage();
            $linkedInMessage->setContent($messageContent);
            $linkedInMessage->setJobOffer($jobOffer);
            $linkedInMessage->setAppUser($this->getUser());

            $entityManager->persist($linkedInMessage);
            $entityManager->flush();

            return $this->json([
                'id' => $linkedInMessage->getId(),
                'content' => $linkedInMessage->getContent(),
                'createdAt' => $linkedInMessage->getCreatedAt()->format('Y-m-d H:i:s')
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return $this->json([
                'error' => 'An error occurred while generating the message'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'app_linkedin_message_show', methods: ['GET'])]
    public function show(LinkedInMessage $linkedInMessage): Response
    {
        // Vérifier que l'utilisateur est propriétaire du message
        if ($linkedInMessage->getAppUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only view your own LinkedIn messages.');
        }

        return $this->render('linkedin_message/show.html.twig', [
            'linkedin_message' => $linkedInMessage
        ]);
    }

    private function generateMessageContent(JobOffer $jobOffer): string
    {
        $contactPerson = $jobOffer->getContactPerson() ?: 'Madame, Monsieur';
        
        $template = <<<EOT
Bonjour {$contactPerson},

Je vous contacte au sujet du poste de {$jobOffer->getTitle()} chez {$jobOffer->getCompany()}.

Mon profil correspond parfaitement aux compétences recherchées pour ce poste. Je suis particulièrement intéressé(e) par cette opportunité car elle correspond à mes objectifs professionnels.

J'aimerais pouvoir échanger avec vous pour discuter plus en détail de ma candidature et de ma potentielle contribution à votre équipe.

Merci d'avance pour votre retour.

Cordialement,
{$this->getUser()->getFirstName()} {$this->getUser()->getLastName()}
EOT;

        return $template;
    }
}