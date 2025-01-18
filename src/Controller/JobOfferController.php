<?php

namespace App\Controller;

use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JobOfferController extends AbstractController
{
    #[Route('/job-offers', name: 'app_job_offer_all', methods: 'GET')]
    public function all(JobOfferRepository $jor): Response
    {
        $jobs = $jor->findBy(['app_user' => $this->getUser()]);
        return $this->render('job_offer/list.html.twig', ['jobs' => '$jobs']);
    }
};
