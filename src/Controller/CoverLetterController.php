<?php

namespace App\Controller;

use App\Entity\CoverLetter;
use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/cover-letter')]
// #[IsGranted('ROLE_USER')]
class CoverLetterController extends AbstractController
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        // private readonly string $geminiApiKey
    ) {}

    #[Route('/generate', name: 'app_cover_letter_generate', methods: ['POST'])]
    public function generate(
        Request $request, 
        EntityManagerInterface $entityManager
    ): JsonResponse {
        try {
            $data = json_decode($request->getContent(), true);

            if (!isset($data['jobOfferId'])) {
                return $this->json([
                    'success' => false,
                    'error' => 'Job offer ID is required'
                ], Response::HTTP_BAD_REQUEST);
            }

            // Récupérer l'offre d'emploi
            $jobOffer = $entityManager->getRepository(JobOffer::class)->find($data['jobOfferId']);

            if (!$jobOffer) {
                return $this->json([
                    'success' => false,
                    'error' => 'Job offer not found'
                ], Response::HTTP_NOT_FOUND);
            }

            if ($jobOffer->getAppUser() !== $this->getUser()) {
                return $this->json([
                    'success' => false,
                    'error' => 'Access denied'
                ], Response::HTTP_FORBIDDEN);
            }

            // Préparer le prompt pour Gemini
            $prompt = $this->prepareGeminiPrompt($jobOffer, $this->getUser());

            // Appeler l'API Gemini
            $coverLetterContent = $this->generateWithGemini($prompt);

            // Créer et sauvegarder la lettre de motivation
            $coverLetter = new CoverLetter();
            $coverLetter->setContent($coverLetterContent);
            $coverLetter->setJobOffer($jobOffer);
            $coverLetter->setAppUser($this->getUser());

            $entityManager->persist($coverLetter);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'data' => [
                    'id' => $coverLetter->getId(),
                    'content' => $coverLetter->getContent(),
                    'createdAt' => $coverLetter->getCreatedAt()->format('Y-m-d H:i:s')
                ]
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'error' => 'An error occurred while generating the cover letter'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'app_cover_letter_show', methods: ['GET'])]
    public function show(CoverLetter $coverLetter): Response
    {
        if ($coverLetter->getAppUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only view your own cover letters.');
        }

        return $this->render('cover_letter/show.html.twig', [
            'cover_letter' => $coverLetter
        ]);
    }

    private function prepareGeminiPrompt(JobOffer $jobOffer, $user): string
    {
        return <<<EOT
Générer une lettre de motivation professionnelle en français pour le poste suivant:

Poste: {$jobOffer->getTitle()}
Entreprise: {$jobOffer->getCompany()}
Localisation: {$jobOffer->getLocation()}

Candidat:
Nom: {$user->getFirstName()} {$user->getLastName()}

Instructions:
- La lettre doit être formelle et professionnelle
- Mentionner spécifiquement le poste et l'entreprise
- Inclure une formule d'introduction et de conclusion appropriée
- Structurer en 3-4 paragraphes
- Mettre l'accent sur la motivation et l'adéquation au poste
- Utiliser un ton professionnel mais engageant
- Ajouter des balises <br> pour les sauts de ligne HTML
EOT;
    }

    private function generateWithGemini(string $prompt): string
    {
        $response = $this->httpClient->request('POST', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent', [
            'headers' => [
                'Content-Type' => 'application/json',
                // 'x-goog-api-key' => $this->geminiApiKey,
            ],
            'json' => [
                'contents' => [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ]
            ]
        ]);

        $data = $response->toArray();
        
        // Extraire le contenu généré de la réponse de Gemini
        $generatedContent = $data['candidates'][0]['content']['parts'][0]['text'];
        
        // Nettoyer et formater le contenu si nécessaire
        return $this->formatCoverLetterContent($generatedContent);
    }

    private function formatCoverLetterContent(string $content): string
    {
        // Nettoyer le contenu et ajouter le formatage HTML si nécessaire
        $content = trim($content);
        $content = nl2br($content);
        
        return $content;
    }
}