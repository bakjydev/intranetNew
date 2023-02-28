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
        // Récupérer la date actuelle
        $now = new \DateTime();

        // Ajouter un jour à la date actuelle pour inclure les anniversaires d'aujourd'hui
        $now->add(new \DateInterval('P1D'));

        // Récupérer le prochain anniversaire
        $nextBirthday = $userRepository->createQueryBuilder('u')
            ->where('DATE_FORMAT(u.birthday, \'%m-%d\') >= :now')
            ->setParameter('now', $now->format('m-d'))
            ->orderBy('u.birthday', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        // Rendre la vue avec le prochain anniversaire
        return $this->render('home/index.html.twig', [
            'now' => $now,
            'nextBirthday' => $nextBirthday,
        ]);
    }
}
