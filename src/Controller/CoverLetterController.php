<?php

namespace App\Controller;

use App\Service\ConfigGeminiIA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CoverLetterController extends AbstractController
{
    #[Route('/api/cover-letter/generate', name: 'app_cover_letter_generate', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function generateCoverLetter(Request $request, ConfigGeminiIA $geminiIA): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'User must be logged in'], Response::HTTP_UNAUTHORIZED);
        }

        // Récupérer les données de la requête
        $data = json_decode($request->getContent(), true);
        $prompt = $data['prompt'] ?? null;

        if (!$prompt) {
            return new JsonResponse(['error' => 'Prompt is required'], Response::HTTP_BAD_REQUEST);
        }

        try {
            // Préparer le prompt complet pour l'IA
            $fullPrompt = "Please write a professional cover letter with the following request: " . $prompt;
            
            // Générer la lettre avec Gemini IA
            $coverLetter = $geminiIA->generateContent($fullPrompt);

            // Retourner la réponse
            return new JsonResponse([
                'success' => true,
                'coverLetter' => $coverLetter
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Failed to generate cover letter: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/api/cover-letter/save', name: 'app_cover_letter_save', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function saveCoverLetter(Request $request): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'User must be logged in'], Response::HTTP_UNAUTHORIZED);
        }

        // TODO: Implémenter la sauvegarde de la lettre de motivation
        // Cette méthode sera développée plus tard pour sauvegarder la lettre en base de données

        return new JsonResponse(['success' => true]);
    }
}