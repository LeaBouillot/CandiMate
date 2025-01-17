<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegislationController extends AbstractController
{
    #[Route('/regislation', name: 'app_regislation')]
    public function index(): Response
    {
        return $this->render('regislation/index.html.twig', [
            'controller_name' => 'RegislationController',
        ]);
    }
}
