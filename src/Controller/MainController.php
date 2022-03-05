<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'firstname'=>'Jeannet',
            'lastname'=>'julie',
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/', name: 'app_template')]
    public function template(): Response
    {
        return $this->render('template.html.twig', [
            'firstname'=>'Jeannet',
            'lastname'=>'julie',
            'controller_name' => 'MainController',
        ]);
    }
}
