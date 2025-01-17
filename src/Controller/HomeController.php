<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        // dd($request);
        return new Response('Bonjour' . $request->query->get('name', ' Chère Client'));
        return $this->render('/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
