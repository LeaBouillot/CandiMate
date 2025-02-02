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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Enum\JobStatus;

#[Route('/job-offers')]
#[IsGranted('ROLE_USER')]
class JobOfferController extends AbstractController
{
    #[Route('', name: 'app_job_offer_list', methods: ['GET'])]
    public function list(JobOfferRepository $jobOfferRepository): Response
    {
        return $this->render('job_offer/list.html.twig', [
            'job_offers' => $jobOfferRepository->findBy(['app_user' => $this->getUser()]),
        ]);
    }

    #[Route('/new', name: 'app_job_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jobOffer = new JobOffer();
        $jobOffer->setAppUser($this->getUser());
        
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jobOffer);
            $entityManager->flush();

            $this->addFlash('success', 'Job offer has been created successfully.');
            return $this->redirectToRoute('app_job_offer_list');
        }

        return $this->render('job_offer/new.html.twig', [
            'job_offer' => $jobOffer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_job_offer_show', methods: ['GET'])]
    public function show(JobOffer $jobOffer): Response
    {
        // Vérifie si l'utilisateur actuel est le propriétaire de l'offre
        if ($jobOffer->getAppUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only view your own job offers.');
        }

        return $this->render('job_offer/show.html.twig', [
            'job_offer' => $jobOffer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_job_offer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobOffer $jobOffer, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si l'utilisateur actuel est le propriétaire de l'offre
        if ($jobOffer->getAppUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only edit your own job offers.');
        }

        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Job offer has been updated successfully.');
            return $this->redirectToRoute('app_job_offer_list');
        }

        return $this->render('job_offer/edit.html.twig', [
            'job_offer' => $jobOffer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_job_offer_delete', methods: ['POST'])]
    public function delete(Request $request, JobOffer $jobOffer, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si l'utilisateur actuel est le propriétaire de l'offre
        if ($jobOffer->getAppUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only delete your own job offers.');
        }

        if ($this->isCsrfTokenValid('delete'.$jobOffer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($jobOffer);
            $entityManager->flush();

            $this->addFlash('success', 'Job offer has been deleted successfully.');
        }

        return $this->redirectToRoute('app_job_offer_list');
    }
}