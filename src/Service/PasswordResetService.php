<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;

class PasswordResetService
{
    private $mailer;
    private $userRepository;

    public function __construct(MailerInterface $mailer, UserRepository $userRepository)
    {
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
    }

    public function sendResetLink(string $email): bool
    {
        // Rechercher l'utilisateur dans la base de données
        $user = $this->userRepository->findOneByEmail($email);

        if (!$user) {
            return false; // Aucun utilisateur trouvé avec cet email
        }

        // Générer un token unique pour la réinitialisation du mot de passe (exemple simple)
        $token = bin2hex(random_bytes(32));

        // Créer l'email
        $emailMessage = (new Email())
            ->from('no-reply@example.com')
            ->to($email)
            ->subject('Réinitialisation de votre mot de passe')
            ->html("<p>Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant :</p><p><a href='/reset-password?token=$token'>Réinitialiser mon mot de passe</a></p>");

        // Envoyer l'email
        $this->mailer->send($emailMessage);

        // Si tout se passe bien, renvoyer true
        return true;
    }
}
