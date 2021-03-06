<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{

    #[Route('/tab/users', name: 'app_tab_users')]
    public function users(UsersRepository $repo): Response
    {
        
        $users=$repo->findAll();

        return $this->render('tab/users.html.twig', [
            'users'=>$users
        ]);
    }
    
}
