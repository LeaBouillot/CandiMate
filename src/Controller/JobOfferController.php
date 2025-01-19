<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Form\JobOfferType;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JobOfferController extends AbstractController
{
    #[Route('/job-offers', name: 'app_job_offer_index', methods: 'GET')]
    public function index(JobOfferRepository $jr): Response
    {
        $jobOffers = $jr->findAll();
        return $this->render(
            'job_offer/list.html.twig',
            ['job_offers' => $jobOffers,]
        );
    }
    // <a href="{{ path('app_job_offer_show', {id: job_offer.id}) }}" 
    #[Route('/job-offers/{id}', name: 'app_job_offer_show', methods: 'GET')]
    public function show(string $id, JobOfferRepository $jr): Response
    {
        // Recherche l'offre d'emploi avec l'ID donné
        $jobOffer = $jr->find($id);

        // Si l'offre d'emploi n'est pas trouvée, une exception est levée
        if (!$jobOffer) {
            throw $this->createNotFoundException('Aucune offre d\'emploi trouvée avec l\'ID : ' . $id);
        }

        // Rendu de la vue avec l'offre trouvée
        return $this->render('job_offer/show.html.twig', [
            'job_offer' => $jobOffer,
        ]);
    }


    // créer
    #[Route('/job-offers/new', name: 'app_job_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $jobOffer = new JobOffer();
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde l'offre d'emploi
            $em->persist($jobOffer);
            $em->flush();

            // Redirige vers la page de l'offre nouvellement créée en utilisant l'ID de l'offre
            return $this->redirectToRoute('app_job_offer_show', ['id' => $jobOffer->getId()]);
        }

        return $this->render('job_offer/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // modifier
    #[Route('/job-offers/{id}/edit', name: 'app_job_offer_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, JobOfferRepository $jr, EntityManagerInterface $em): Response
    {
        $jobOffer = $jr->find($id);
        if (!$jobOffer) {
            throw $this->createNotFoundException('Aucune offre d\'emploi trouvée avec l\'ID : ' . $id);
        }

        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde des modifications
            $em->persist($jobOffer);
            $em->flush();
            $this->addFlash('success', 'L\'offre d\'emploi a été créée avec succès');
            return $this->redirectToRoute('app_job_offer_show', ['id' => $jobOffer->getId()]);
        }

        return $this->render('job_offer/edit.html.twig', [
            'job_offer' => $jobOffer,
            'form' => $form->createView(),
        ]);
    }

    // supprimer
    #[Route('/job-offers/{id}', name: 'app_job_offer_delete', methods: 'DELETE')]
    public function delete(int $id, JobOfferRepository $jr, EntityManagerInterface $em): Response
    {
        $jobOffer = $jr->find($id);
        if (!$jobOffer) {
            throw $this->createNotFoundException('Aucune offre d\'emploi trouvée avec l\'ID : ' . $id);
        }
        // 2. Supprimer l'offre d'emploi
        $em->remove($jobOffer);
        $em->flush();

        // 3. Ajouter un message flash pour confirmer la suppression
        $this->addFlash('success', 'L\'offre d\'emploi a été supprimée avec succès.');

        // 4. Rediriger l'utilisateur vers la liste des offres d'emploi
        return $this->redirectToRoute('app_dashboard');
    }
};
