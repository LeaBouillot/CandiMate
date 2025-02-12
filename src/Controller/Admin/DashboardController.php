<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\JobOffer;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractController
{#[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        $jobOffers = $em->createQueryBuilder()
            ->select('j, u')
            ->from('App\Entity\JobOffer', 'j')
            ->leftJoin('j.app_user', 'u')
            ->getQuery()
            ->getResult();
        
        return $this->render('admin/dashboard.html.twig', [
            'job_offers' => $jobOffers
        ]);
    }

    #[Route('/admin/job-offer/{id}/delete', name: 'app_admin_job_offer_delete', methods: ['POST'])]
    public function delete(JobOffer $jobOffer, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($jobOffer);
        $entityManager->flush();
        
        $this->addFlash('success', 'Job offer deleted successfully');
        return $this->redirectToRoute('app_admin_dashboard');
    }
}

// 18-joindre l'entité Utilisateur à JobOffer pour garantir que  disposition de données complètes : Cela garantit que toutes les données utilisateur sont chargées correctement via une jointure, évitant ainsi l'erreur introuvable.