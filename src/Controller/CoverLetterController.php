<?php

namespace App\Controller;

use Gemini;
use App\Entity\CoverLetter;
use App\Entity\JobOffer;
use App\Repository\CoverLetterRepository;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/cover-letter')]
#[IsGranted('ROLE_USER')]
// #[IsGranted('IS_AUTHENTICATED_FULLY')]
class CoverLetterController extends AbstractController
{
    #[Route('/generate/{id}', name: 'app_cover_letter_generate', methods: ['GET'])]
    public function generate(
        JobOffer $jobOffer,
        EntityManagerInterface $em
    ): Response {
        // Vérifier que l'utilisateur est propriétaire de l'offre
        if ($jobOffer->getAppUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à générer une lettre pour cette offre.');
            return $this->redirectToRoute('app_home');
        }
    
        try {
            $user = $this->getUser();
            $company = $jobOffer->getCompany();
            $title = $jobOffer->getTitle();
            $contactPerson = $jobOffer->getContactPerson() ?: "Madame, Monsieur";
    
            // Génération avec Gemini AI
            $yourApiKey = $this->getParameter('GEMINI_API_KEY');
            $client = Gemini::client($yourApiKey);
            $result = $client->geminiPro()->generateContent(
                "Je veux une lettre de motivation professionnelle qui commence par 'Bonjour Mme. Mr. " . $contactPerson . ",' pour la compagnie " . $company . " pour le poste de " . $title . ". 
                Voici les informations pour aider la création de la lettre de motivation :
                Mon nom est " . $user->getLastName() . " et mon prénom est " . $user->getFirstName() . ".
                La lettre doit être structurée, professionnelle et convaincante.
                Elle doit inclure :
                - Une introduction percutante
                - Mes motivations pour rejoindre l'entreprise
                - Mes compétences principales en lien avec le poste
                - Une conclusion avec une demande d'entretien
                Je voudrais qu'à chaque saut de ligne tu me rajoutes la balise html <br>."
            );
    
            // Création de la lettre
            $coverLetter = new CoverLetter();
            $coverLetter
                ->setContent($result->text())
                ->setJobOffer($jobOffer)
                ->setAppUser($user);
    
            $em->persist($coverLetter);
            $em->flush();
    
            $this->addFlash('success', 'Lettre de motivation générée avec succès.');
            return $this->redirectToRoute('app_cover_letter_show', ['id' => $coverLetter->getId()]);
    
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de la génération de la lettre.');
            return $this->redirectToRoute('app_job_offer_show', ['id' => $jobOffer->getId()]);
        }
    }

    #[Route('/{id}', name: 'app_cover_letter_show', methods: ['GET'])]
    public function show(CoverLetter $coverLetter): Response
    {
        // Vérifier que l'utilisateur est propriétaire de la lettre
        if ($coverLetter->getAppUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à voir cette lettre.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('cover_letter/show.html.twig', [
            'coverLetter' => $coverLetter,
            'jobOfferName' => $coverLetter->getJobOffer()->getTitle(),
            'jobOffer' => $coverLetter->getJobOffer(),
            'CLContent' => $coverLetter->getContent()
        ]);
    }

    #[Route('/{id}/update', name: 'app_cover_letter_update', methods: ['POST'])]
    public function update(
        Request $request,
        CoverLetter $coverLetter,
        EntityManagerInterface $em
    ): JsonResponse {
        // Vérifier que l'utilisateur est propriétaire de la lettre
        if ($coverLetter->getAppUser() !== $this->getUser()) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à modifier cette lettre.'
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            $data = json_decode($request->getContent(), true);
            
            if (!isset($data['content'])) {
                throw new \InvalidArgumentException('Le contenu est requis');
            }

            $coverLetter->setContent($data['content']);
            $em->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Lettre mise à jour avec succès'
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}/delete', name: 'app_cover_letter_delete', methods: ['POST'])]
    public function delete(
        CoverLetter $coverLetter,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        // Vérifier que l'utilisateur est propriétaire de la lettre
        if ($coverLetter->getAppUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à supprimer cette lettre.');
            return $this->redirectToRoute('app_home');
        }

        // Vérifier le token CSRF
        if (!$this->isCsrfTokenValid('delete', $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_cover_letter_show', ['id' => $coverLetter->getId()]);
        }

        try {
            $em->remove($coverLetter);
            $em->flush();

            $this->addFlash('success', 'Lettre de motivation supprimée avec succès.');
            return $this->redirectToRoute('app_dashboard');

        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de la suppression.');
            return $this->redirectToRoute('app_cover_letter_show', ['id' => $coverLetter->getId()]);
        }
    }

    #[Route('/job/{id}/list', name: 'app_cover_letter_list', methods: ['GET'])]
    public function list(JobOffer $jobOffer): Response
    {
        // Vérifier que l'utilisateur est propriétaire de l'offre
        if ($jobOffer->getAppUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à voir ces lettres.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('cover_letter/list.html.twig', [
            'coverLetters' => $jobOffer->getCoverLetters(),
            'jobOffer' => $jobOffer
        ]);
    }
}