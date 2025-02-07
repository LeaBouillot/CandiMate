<?php

namespace App\Controller;

use App\Entity\LinkedInMessage;
use App\Entity\JobOffer;
use App\Repository\JobOfferRepository;
use App\Repository\LinkedInMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Gemini;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/linkedin-message')]
#[IsGranted('ROLE_USER')]
class LinkedInMessageController extends AbstractController
{
    #[Route('/list/{id}', name: 'app_linkedin_list', methods: ['GET'])]
    public function list(int $id, JobOfferRepository $jobOfferRepository): Response
    {
        $jobOffer = $jobOfferRepository->find($id);
        
        if (!$jobOffer) {
            throw $this->createNotFoundException('L\'offre d\'emploi n\'existe pas.');
        }

        // Vérifier que l'utilisateur est propriétaire de l'offre
        if ($jobOffer->getAppUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à voir ces messages.');
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('linkedin_message/list.html.twig', [
            'linkedInMessages' => $jobOffer->getLinkedInMessages(),
            'jobOffer' => $jobOffer
        ]);
    }

    #[Route('/generate/{id}', name: 'app_linkedin_generate', methods: ['GET'])]
    public function generate(
        int $id,
        JobOfferRepository $jobOfferRepository,
        EntityManagerInterface $em
    ): Response {
        $jobOffer = $jobOfferRepository->find($id);
        
        if (!$jobOffer) {
            throw $this->createNotFoundException('L\'offre d\'emploi n\'existe pas.');
        }

        // Vérifier que l'utilisateur est propriétaire de l'offre
        if ($jobOffer->getAppUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à générer un message pour cette offre.');
            return $this->redirectToRoute('app_home');
        }

        try {
            $user = $this->getUser();
            $prompt = "Génère un message LinkedIn court et accrocheur (maximum 200 mots) pour postuler au poste de {$jobOffer->getTitle()} chez {$jobOffer->getCompany()}. " .
                "Le message doit commencer par 'Bonjour " . ($jobOffer->getContactPerson() ?: "Madame, Monsieur") . ",' et doit :" .
                "- Être professionnel et direct" .
                "- Inclure une accroche percutante" .
                "- Mentionner 2-3 points clés sur ma valeur ajoutée" .
                "- Se terminer par une invitation à échanger" .
                "Signature : {$user->getFirstName()} {$user->getLastName()}" .
                "Ajoute <br> pour chaque saut de ligne.";

            // Générer le contenu via Gemini API
            $yourApiKey = $this->getParameter('GEMINI_API_KEY');
            $client = Gemini::client($yourApiKey);
            $result = $client->geminiPro()->generateContent($prompt);

            $linkedInMessage = new LinkedInMessage();
            $linkedInMessage
                ->setContent($result->text())
                ->setJobOffer($jobOffer)
                ->setAppUser($user);

            $em->persist($linkedInMessage);
            $em->flush();

            $this->addFlash('success', 'Message LinkedIn généré avec succès.');
            return $this->redirectToRoute('app_linkedin_show', ['id' => $linkedInMessage->getId()]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de la génération du message.');
            return $this->redirectToRoute('app_job_offer_show', ['id' => $jobOffer->getId()]);
        }
    }

    #[Route('/show/{id}', name: 'app_linkedin_show', methods: ['GET'])]
    public function show(LinkedInMessage $linkedInMessage): Response
    {
        if ($linkedInMessage->getAppUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à voir ce message.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('linkedin_message/show.html.twig', [
            'linkedInMessage' => $linkedInMessage,
            'jobOfferName' => $linkedInMessage->getJobOffer()->getTitle(),
            'LMContent' => $linkedInMessage->getContent(),
            'jobOffer' => $linkedInMessage->getJobOffer()
        ]);
    }

    #[Route('/delete/{id}', name: 'app_linkedin_delete', methods: ['POST'])]
    public function delete(
        LinkedInMessage $linkedInMessage,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        if ($linkedInMessage->getAppUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à supprimer ce message.');
            return $this->redirectToRoute('app_home');
        }

        try {
            $jobOfferId = $linkedInMessage->getJobOffer()->getId();
            $em->remove($linkedInMessage);
            $em->flush();

            $this->addFlash('success', 'Message LinkedIn supprimé avec succès.');
            return $this->redirectToRoute('app_job_offer_show', ['id' => $jobOfferId]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de la suppression.');
            return $this->redirectToRoute('app_linkedin_show', ['id' => $linkedInMessage->getId()]);
        }
    }

    #[Route('/update/{id}', name: 'app_linkedin_update', methods: ['POST'])]
    public function update(
        Request $request,
        LinkedInMessage $linkedInMessage,
        EntityManagerInterface $em
    ): JsonResponse {
        if ($linkedInMessage->getAppUser() !== $this->getUser()) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à modifier ce message.'
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            $data = json_decode($request->getContent(), true);
            
            if (!isset($data['content'])) {
                throw new \InvalidArgumentException('Le contenu est requis');
            }

            $linkedInMessage->setContent($data['content']);
            $em->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Message mis à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}