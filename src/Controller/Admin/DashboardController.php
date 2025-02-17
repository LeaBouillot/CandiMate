<?php

namespace App\Controller\Admin;

use App\Controller\Admin\JobOfferCrudController;
use App\Controller\Admin\UserCrudController;
use App\Controller\Admin\CoverLetterCrudController;
use App\Controller\Admin\LinkedInMessageCrudController;
use App\Entity\JobOffer;
use App\Entity\User;
use App\Entity\CoverLetter;
use App\Entity\LinkedInMessage;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AdminUrlGenerator $adminUrlGenerator
    ) {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'stats' => [
                'users_count' => $this->entityManager->getRepository(User::class)->count([]),
                'job_offers_count' => $this->entityManager->getRepository(JobOffer::class)->count([]),
                'cover_letters_count' => $this->entityManager->getRepository(CoverLetter::class)->count([]),
                'linkedin_messages_count' => $this->entityManager->getRepository(LinkedInMessage::class)->count([]),
            ],
            'recent_users' => $this->entityManager->getRepository(User::class)->findBy([], ['createdAt' => 'DESC'], 5),
            'recent_jobs' => $this->entityManager->getRepository(JobOffer::class)->findBy([], ['createdAt' => 'DESC'], 5),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Candimate Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Gestion des offres');
        yield MenuItem::linkToCrud('Offres d\'emploi', 'fa fa-briefcase', JobOffer::class)
            ->setController(JobOfferCrudController::class);

        yield MenuItem::linkToCrud('Lettres de motivation', 'fa fa-file-text', CoverLetter::class)
            ->setController(CoverLetterCrudController::class);

        yield MenuItem::linkToCrud('Messages LinkedIn', 'fa fa-linkedin', LinkedInMessage::class)
            ->setController(LinkedInMessageCrudController::class);

        yield MenuItem::section('Administration');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class)
            ->setController(UserCrudController::class);

        yield MenuItem::section('Site');
        yield MenuItem::linkToRoute('Retour au site', 'fa fa-arrow-left', 'app_home');
    }
}
