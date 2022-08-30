<?php

namespace App\Controller;

use App\Entity\Todos;
use App\Form\TodosType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    #[Route('/todos', name: 'app_todos')]
    public function index(): Response
    {
        return $this->render('todos/index.html.twig', [
            'controller_name' => 'TodosController',
        ]);
    }

    #[Route('/todos/add', name: 'add_todos')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $todo=new Todos;
        $form = $this->createForm(TodosType::class, $todo);
        $form->handleRequest($request);
        $manager=$doctrine->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) { 
            // si option 2 c'est l'utilisateur authentifié qui s'ajoute des tâches
            // $todo->addUser($user);
            $manager->persist($todo);
            $manager->flush();
            $message='a été ajoutée avec succes';
            $this->addFlash(
               'success',
               $message
            ); 
            $this->redirectToRoute('app_todo');           
        }
        

        return $this->render('todos/add-todo.html.twig', [
            'form'=>$form->createView(),
            // 'controller_name' => 'TodosController',
        ]);
    }




}
