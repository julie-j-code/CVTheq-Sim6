<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionsController extends AbstractController
{
    #[Route('/sessions', name: 'app_sessions')]
    public function index(Request $request): Response
    {
        // équivalent de session_start
        $session = $request->getSession();

        if ($session->has('nbVisite')) {
            $nbrVisite = $session->get('nbVisite') + 1;
        } else {
            $nbrVisite = 1;
        }
        $session->set('nbVisite', $nbrVisite);
        return $this->render('sessions/index.html.twig', [
            'nbrVisite' => $nbrVisite,
            'name' => 'Julie',
            'controller_name' => 'SessionsController',
        ]);
    }
}
