<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/', name: 'dashboard')]
    public function template(): Response
    {
        return $this->render('template.html.twig', [
            'firstname'=>'Jeannet',
            'lastname'=>'julie'
        ]);
    }
}
