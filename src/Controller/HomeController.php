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
        return $this->render('home/legal_notice.html.twig', []);
    }

    #[Route('/policy', name: 'app_policy')]
    public function policy(): Response
    {
        return $this->render('home/policy.html.twig', []);
    }
}
