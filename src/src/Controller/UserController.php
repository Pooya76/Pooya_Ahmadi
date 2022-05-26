<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/show_all', name: 'app_all_user')]
    public function showAllUser(UserRepository $userRepository): Response
    {
        $allUsers = $userRepository->findAll();
        return $this->render('user/show_all.html.twig', [
            'users' => $allUsers,
        ]);
    }
}
