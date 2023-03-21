<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessageType;
use App\Repository\MessagesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    #[Route('/send', name: 'app_message_send')]
    public function send(Request $request, ManagerRegistry $doctrine) : Response
    {
        $message = new Messages;
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $message->setSender($this->getUser());

            $em = $doctrine->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message envoyé avec succés");
            return $this->redirectToRoute("app_message");
        }

      return $this->render("message/send.html.twig", [
          "formSend"=> $form->createView()
      ]);
    }

    #[Route('/received', name: 'app_message_received')]
    public function received(): Response
    {
        return $this->render('message/received.html.twig');
    }

    #[Route('/sent', name: 'app_message_sent')]
    public function sent(): Response
    {
        return $this->render('message/sent.html.twig');
    }

    #[Route('/read/{id}', name: 'app_message_read')]
    public function read(Messages $message, ManagerRegistry $doctrine): Response
    {
        $message->setIsRead(true);
        $em = $doctrine->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('message/read.html.twig', compact("message"));
    }

    #[Route('/valid/{id}', name: 'app_message_valid')]
    public function valid(Messages $message, ManagerRegistry $doctrine): Response
    {
        $message->setIsValid(true);
        $em = $doctrine->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('message/received.html.twig', compact("message"));
    }

    #[Route('/delete/{id}', name: 'app_message_delete')]
    public function delete(Messages $message, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($message);
        $em->flush();

        return $this->render('message/received.html.twig');
    }

    #[Route('/decline/{id}', name: 'app_message_decline')]
    public function decline(Messages $message, ManagerRegistry $doctrine): Response
    {
        $message->setIsValid(false);
        $em = $doctrine->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('message/received.html.twig');
    }
}
