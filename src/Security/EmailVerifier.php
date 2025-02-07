<?php

namespace App\Security;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class EmailVerifier
{
    public function __construct(
        private readonly VerifyEmailHelperInterface $verifyEmailHelper,
        private readonly MailerInterface $mailer,
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Envoie un email de confirmation avec un lien signé
     *
     * @throws TransportExceptionInterface En cas d'erreur d'envoi
     */
    public function sendEmailConfirmation(string $verifyEmailRouteName, User $user, TemplatedEmail $email): void
    {
        try {
            $signatureComponents = $this->verifyEmailHelper->generateSignature(
                $verifyEmailRouteName,
                (string) $user->getId(),
                $user->getEmail(),
                ['userId' => $user->getId()]
            );

            $context = $email->getContext();
            $context['signedUrl'] = $signatureComponents->getSignedUrl();
            $context['expiresAt'] = new DateTimeImmutable('+24 hours');
            $context['userName'] = $user->getFirstName();

            $email->context($context);

            $this->mailer->send($email);

            $this->logger->info('Email de vérification envoyé', [
                'user_id' => $user->getId(),
                'email' => $user->getEmail()
            ]);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error('Erreur lors de l\'envoi de l\'email de vérification', [
                'error' => $e->getMessage(),
                'user_id' => $user->getId()
            ]);
            throw $e;
        }
    }

    /**
     * Vérifie et active le compte utilisateur
     *
     * @throws VerifyEmailExceptionInterface Si la vérification échoue
     */
    public function handleEmailConfirmation(Request $request, User $user): void
    {
        try {
            $this->verifyEmailHelper->validateEmailConfirmationFromRequest(
                $request,
                (string) $user->getId(),
                $user->getEmail()
            );

            $user->setVerified(true);
            $user->setUpdatedAt(new DateTimeImmutable());

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->logger->info('Compte utilisateur vérifié avec succès', [
                'user_id' => $user->getId()
            ]);
        } catch (VerifyEmailExceptionInterface $e) {
            $this->logger->warning('Échec de la vérification email', [
                'error' => $e->getReason(),
                'user_id' => $user->getId()
            ]);
            throw $e;
        }
    }

    /**
     * Vérifie si l'email est déjà vérifié
     */
    public function isEmailVerified(User $user): bool
    {
        return $user->isVerified();
    }
}

// namespace App\Security;

// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Bridge\Twig\Mime\TemplatedEmail;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\Security\Core\User\UserInterface;
// use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
// use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

// class EmailVerifier
// {
//     public function __construct(
//         private VerifyEmailHelperInterface $verifyEmailHelper,
//         private MailerInterface $mailer,
//         private EntityManagerInterface $entityManager
//     ) {
//     }

//     public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void
//     {
//         $signatureComponents = $this->verifyEmailHelper->generateSignature(
//             $verifyEmailRouteName,
//             $user->getId(),
//             $user->getEmail(),
//             ['id' => $user->getId()]
//         );

//         $context = $email->getContext();
//         $context['signedUrl'] = $signatureComponents->getSignedUrl();
//         $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
//         $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

//         $email->context($context);

//         $this->mailer->send($email);
//     }

//     /**
//      * @throws VerifyEmailExceptionInterface
//      */
//     public function handleEmailConfirmation(Request $request, UserInterface $user): void
//     {
//         $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

//         if ($user instanceof \App\Entity\User) {
//             $user->setVerified(true);
//             $this->entityManager->persist($user);
//             $this->entityManager->flush();
//         }
//     }
// }