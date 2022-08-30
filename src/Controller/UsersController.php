<?php

namespace App\Controller;

use App\Repository\UsersRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'users')]
    public function index(UsersRepository $repo): Response
    {
        
        $users=$repo->findAll();
        return $this->render('users/index.html.twig', [
            'users' => $users,
            'controller_name' => 'UsersController',
        ]);
    }

    
}
