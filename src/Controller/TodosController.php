<?php

namespace App\Controller;

use App\Entity\Todos;
use App\Form\TodosType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
    public function add(Request $request, ManagerRegistry $doctrine, Security $security ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $security->getUser();

        $todo=new Todos;
        $form = $this->createForm(TodosType::class, $todo);
        $form->handleRequest($request);
        $manager=$doctrine->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) { 
            // si option 2 c'est l'utilisateur authentifié qui s'ajoute des tâches
            $todo->addUser($user);
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
            'user'=>$user,
            'controller_name' => 'TodosController',
        ]);
    }
}
