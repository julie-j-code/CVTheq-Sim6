<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{

    #[Route('/tab/users', name: 'app_tab_users')]
    public function users(): Response
    {
        
        $users=[
            [
                'age'=>20,
                'lastname'=>'sebastien',
                'firstname'=>'dubosque'

            ],
            [
                'age'=>30,
                'lastname'=>'julie',
                'firstname'=>'durand'

            ]
        ];

        return $this->render('tab/users.html.twig', [
            'users'=>$users
        ]);
    }
}
