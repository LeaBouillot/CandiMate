<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route(path: '/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
    // #[Route(path: '/forgot-password', name: 'app_forgot_password')]

    // public function forgotPassword(Request $request): Response
    // {
    //     $success = null; // Valeur par défaut

    //     if ($request->isMethod('POST')) {
    //         $email = $request->request->get('email');

    //         // Appeler un service pour envoyer l'email de réinitialisation du mot de passe
    //         $result = $this->passwordResetService->sendResetLink($email);

    //         if ($result) {
    //             $success = 'Un lien de réinitialisation a été envoyé à votre adresse email.';
    //         } else {
    //             $error = 'Aucun compte trouvé avec cet email.';
    //         }
    //     }

    //     return $this->render('security/forgot_password.html.twig', [
    //         'success' => $success,  // La variable success est passée ici
    //         'error' => $error ?? null, // La variable error est également transmise si nécessaire
    //     ]);
    // }



