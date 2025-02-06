<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProfileType;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/profile')]
#[IsGranted('ROLE_USER')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class ProfileController extends AbstractController
{
   #[Route('', name: 'app_profile_show', methods: ['GET'])]
   public function show(): Response
   {
       return $this->render('profile/show.html.twig', [
           'user' => $this->getUser()
       ]);
   }

   #[Route('/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
   public function edit(Request $request, EntityManagerInterface $entityManager): Response
   {
       $user = $this->getUser();
       $form = $this->createForm(ProfileType::class, $user);
       $form->handleRequest($request);
   
       if ($form->isSubmitted() && $form->isValid()) {
           $imageFile = $form->get('imageFile')->getData();
           
           if ($imageFile) {
               // Si une image est téléchargée, on gère le fichier
               $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
               $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
   
               try {
                   $imageFile->move(
                       $this->getParameter('profile_images_directory'),
                       $newFilename
                   );
                   $user->setImage($newFilename);
               } catch (\Exception $e) {
                   $this->addFlash('error', 'Error uploading image');
                   return $this->redirectToRoute('app_profile_edit');
               }
           } else {
               // Si aucune image n'a été téléchargée, on assigne l'image par défaut
               $user->setImage('default.png');
           }
   
           $entityManager->flush();
           $this->addFlash('success', 'Profile updated successfully');
           return $this->redirectToRoute('app_profile_show');
       }
   
       return $this->render('profile/edit.html.twig', [
           'form' => $form->createView(),
       ]);
   }   
}