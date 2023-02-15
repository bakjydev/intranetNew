<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin', name: 'app_admin')]
    public function userList(UserRepository $userRepository)
    {
        return $this->render('admin/index.html.twig', [
            'userRepository' => $userRepository->findAll(),
        ]);
    }

    #[Route('/admin/modifier/{id}', name: 'app_edituser')]
    public function editUser(User $user, Request $request,  ManagerRegistry $doctrine)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateurs modifier avec succés');
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView()
        ]);

    }


}
