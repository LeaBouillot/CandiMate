<?php

namespace App\Controller;

use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(JobOfferRepository $jr): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/legal_notice', name: 'app_legal_notice')]
    public function legal(): Response
    {
        return $this->render('home/legal_notice.html.twig', [
            'site_url' => 'https://leabouillot.top',
            'owner' => 'Bouillot',
            'address' => '42 BD Paul Vaillant Couturier 93100 Montreuil',
            'publication_manager' => 'Bouillot',
            'webmaster' => 'Bouillot',
            'host' => 'Hostinger – 61 Lordou Vironos st. 6023 Larnaca',
            'dpo' => 'Bouillot',
            'company_name' => 'Bouillot',
            'data_controller' => 'Bouillot',
            'jurisdiction' => 'Montreuil'
        ]);
    }

    #[Route('/policy', name: 'app_policy')]
    public function policy(): Response
    {
        return $this->render('home/policy.html.twig', []);
    }
}
