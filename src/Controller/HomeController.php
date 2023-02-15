<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function userBirthday(UserRepository $userRepository)
    {
        return $this->render('home/index.html.twig', [
            'userRepository' => $userRepository->findBy(
                array(),                       // $where
                array(),                       // $orderBy
                1,                        // $limit
                0                        // $offset
            )
        ]);
    }
}
