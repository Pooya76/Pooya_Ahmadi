<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Repository\AttractionRepository;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactUsController extends AbstractController
{

    public function index(): Response
    {

        return $this->render('contact_us/index.html.twig', [
            'controller_name' => 'ContactUsController',
        ]);
    }

    #[Route('/contact_us', name: 'app_contact_us')]
    public function new(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {

        $message = new Messages();
        $form = $this->createForm(\MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $message = $form->getData();
            $errors = $validator->validate($message);
            if (count($errors) > 0) {
                $errorsString = (string) $errors;
                return new Response($errorsString);
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($message);
            $entityManager->flush();
            return new Response('Message added successfully');
        }

        return $this->renderForm('contact_us/index.html.twig', [
            'form' => $form,
        ]);

    }

    #[Route('/show_messages', name: 'app_show_messages')]
    public function showAll(MessagesRepository $messagesRepository): Response
    {
        $allMessages = $messagesRepository->findAll();
        return $this->render('contact_us/show.html.twig', [
            'allMessages' => $allMessages
        ]);
    }

    #[Route('/message/{id}', name: 'app_message_view')]
    public function view(Messages $message): Response
    {
        return $this->render('contact_us/view.html.twig',['message' => $message]);
    }
}
