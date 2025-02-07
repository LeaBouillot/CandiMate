<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\User;

#[Route('/admin')]
// #[IsGranted('ROLE_ADMIN')]
class UserCrudController extends AbstractController
{
   #[Route('/users', name: 'app_admin_users')]
   public function index(UserRepository $userRepository): Response
   {
       $users = $userRepository->findAll();
       
       return $this->render('admin/users.html.twig', [
           'users' => $users
       ]);
   }

   #[Route('/user/{id}/delete', name: 'app_admin_user_delete', methods: ['POST'])]
   public function delete(User $user, EntityManagerInterface $em): Response 
   {
       $em->remove($user);
       $em->flush();
       
       $this->addFlash('success', 'User deleted successfully');
       return $this->redirectToRoute('app_admin_users');
   }
}