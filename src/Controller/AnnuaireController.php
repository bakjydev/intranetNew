<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\EditUserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class AnnuaireController extends AbstractController
{
    #[Route('/annuaire', name: 'app_annuaire')]
    public function index(): Response
    {
        return $this->render('annuaire/index.html.twig', [
            'controller_name' => 'AnnuaireController',
        ]);
    }

    #[Route('/annuaire', name: 'app_annuaire')]
    public function userList(UserRepository $userRepository)
    {
        return $this->render('annuaire/index.html.twig', [
            'userRepository' => $userRepository->findAll(),
        ]);
    }
}
