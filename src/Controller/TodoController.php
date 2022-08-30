<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $request): Response
    {

        $session = $request->getSession();
        // afficher notre tableau de todo
        // sinon je l'initialise et l'affiche
        if (!$session->has('todos')) {
            $todos = [
                'offre' => 'publier une offre',
                'recherche' => 'rechercher des candidats',
                'contacts' => 'relance candidatures en cours'
            ];
            $session->set('todos', $todos);
            $this->addFlash('info', 'La liste des todos vient d\'être initialisée');
        }


        return $this->render('todo/index.html.twig');
    }


    #[Route('/todo/add/{name}/{content}', name: 'todo_add')]
    public function addTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        // vérifier si j'ai mon tableau de todo dans la session
        if ($session->has('todos')) {

            // si oui
            // verifier si on a déjà un todo avec le même name
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                // si oui afficher erreur
                $this->addFlash('error', "Ce todo d'id $name existe déjà dans la liste");
            } else {

                //  si non on l'ajoute et on affiche message de succes
                $todos[$name] = $content;
                $this->addFlash('success', "Le todo d'id $name a éjé ajouté à la liste");
                $session->set('todos', $todos);
            }
        } else {

            // si non
            // afficher erreur et rediriger vers le controller initial controller index
            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
        }

        return $this->redirectToRoute('app_todo');
    }


    #[Route('/todo/update/{name}/{content}', name: 'todo_update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        // vérifier si j'ai mon tableau de todo dans la session
        if ($session->has('todos')) {

            // si oui
            // verifier si on a déjà un todo avec le même name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                // si on n'a pas de todo portant ce nom afficher erreur
                $this->addFlash('error', "Ce todo d'id $name n'existe pas dans la liste");
            } else {
                //  si non on le modifie et on affiche message de succes
                $todos[$name] = $content;
                $this->addFlash('success', "Le todo d'id $name a bien été modifié dans la liste");
                $session->set('todos', $todos);
            }
        } else {

            // si non
            // afficher erreur et rediriger vers le controller initial controller index
            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
        }

        return $this->redirectToRoute('app_todo');
    }

    #[Route('/todo/delete/{name}', name: 'todo_delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse
    {
        $session = $request->getSession();
        // vérifier si j'ai mon tableau de todo dans la session
        if ($session->has('todos')) {

            // si oui
            // verifier si on a bien un todo avec le même name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                // si on n'a pas de todo portant ce nom afficher erreur
                $this->addFlash('error', "Ce todo d'id $name n'existe pas dans la liste");
            } else {
                //  si non on le modifie et on affiche message de succes
                // attention unset et non remove
                unset($todos[$name]);
                $this->addFlash('success', "Le todo d'id $name a bien été supprimé de la liste");
                $session->set('todos', $todos);
            }
        } else {

            // si non
            // afficher erreur et rediriger vers le controller initial controller index
            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
        }

        return $this->redirectToRoute('app_todo');
    }


    #[Route('/todo/reset', name: 'todo_reset')]
    public function resetTodo(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('app_todo');
    }
}
