<?php

namespace App\Controller;

use addCandidatEvent;
use App\Entity\Candidats;
use ListAllCandidatsEvent;
use App\Form\CandidatsType;
use App\Services\MailerService;
use App\Repository\CandidatsRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/candidats'), IsGranted('ROLE_USER')]

class CandidatsController extends AbstractController
{

    public function __construct(
        private EventDispatcherInterface $dispatcher
    ) {
    }

    #[Route('/', name: 'candidats')]
    public function index(CandidatsRepository $candidatsRepository): Response

    {

        $candidats = $candidatsRepository->findAll();
        return $this->render('candidats/index.html.twig', [
            'candidats' => $candidats
        ]);
    }

    #[Route('/interval/{ageMin}/{ageMax}', name: 'interval')]
    public function interval(CandidatsRepository $candidatsRepository, $ageMin, $ageMax): Response

    {

        $candidats = $candidatsRepository->findCandidatsByAgeInterval($ageMin, $ageMax);
        return $this->render('candidats/index.html.twig', [
            'candidats' => $candidats
        ]);
    }

    #[Route('/{id<\d+>}', name: 'candidat-detail')]
    // public function detail(CandidatsRepository $candidatsRepository, $id): Response
    public function detail(Candidats $candidat = null): Response

    {
        // on peut ne passer que l'entité à function, grâce au Param convertor...
        // $candidat = $candidatsRepository->find($id);
        if (!$candidat) {
            $this->addFlash(
                'error',
                // "Le candidat d'id $id n'existe pas"
                "Ce candidat n'existe pas"
            );
            return $this->redirectToRoute('candidats');
        }

        return $this->render('candidats/details.html.twig', [
            'candidat' => $candidat
        ]);
    }


    #[Route('/add', name: 'candidats-add')]
    public function addCandidat(ManagerRegistry $doctrine, Request $request, MailerService $mailer): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $manager = $doctrine->getManager();
        $candidat = new Candidats;
        $form = $this->createForm(CandidatsType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $manager->persist($candidat);
            $manager->flush();
            $message = " a été ajouté avec succès";
            $addCandidatEvent = new AddCandidatEvent($candidat);
            $this->dispatcher->dispatch($addCandidatEvent, AddCandidatEvent::ADD_CANDIDAT_EVENT);
            $mailMessage = $candidat->getFirstname().' '.$candidat->getLastname().' '.$message;
            $this->addFlash(
                'success',
                'le candidat a bien été ajouté'
            );
            $mailer->sendEmail(content :  $mailMessage);

            
            return $this->redirectToRoute('candidats');
        }

        return $this->render('candidats/add-candidat.html.twig', [
            'form' => $form->createView()
        ]);
    }


    // initialement, pour l'exercice, on  avait fait un update totalement manuel sans passer par un formulaire...
    #[Route('/edit/{id?0}', name: 'candidats-edit')]
    public function editCandidats(CandidatsRepository $candidatsRepository, $id, ManagerRegistry $doctrine, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $candidat = $candidatsRepository->find($id);
        $new = false;
        //$this->getDoctrine() : Version Sf <= 5
        if (!$candidat) {
            $new = true;
            $candidat = new Candidats();
        }

        // $Candidats est l'image de notre formulaire
        $form = $this->createForm(CandidatsType::class, $candidat);
        // Mon formulaire va aller traiter la requete
        $form->handleRequest($request);
        //Est ce que le formulaire a été soumis
        if ($form->isSubmitted()) {
            // si oui,
            // on va ajouter l'objet Candidats dans la base de données
            $manager = $doctrine->getManager();
            $manager->persist($candidat);

            $manager->flush();
            // Afficher un mssage de succès
            if ($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash('success', $candidat->getFirstName() . $message);
            // Rediriger verts la liste des Candidats
            return $this->redirectToRoute('pagination');
        } else {
            //Sinon
            //On affiche notre formulaire
            return $this->render('candidats/add-candidat.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }


    #[Route('/delete/{id}', name: 'candidats-delete')]

    public function deletePersonne(Candidats $candidat = null, ManagerRegistry $doctrine): RedirectResponse
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // Récupérer la personne
        if ($candidat) {
            // Si la personne existe => le supprimer et retourner un flashMessage de succés
            $manager = $doctrine->getManager();
            // Ajoute la fonction de suppression dans la transaction
            $manager->remove($candidat);
            // Exécuter la transacition
            $manager->flush();
            $this->addFlash('success', "La personne a été supprimé avec succès");
        } else {
            //Sinon  retourner un flashMessage d'erreur
            $this->addFlash('error', "Personne innexistante");
        }
        return $this->redirectToRoute('pagination');
    }



    #[Route('/pagination/{page?1}/{nbr?8}', name: 'pagination')]
    public function pagination(CandidatsRepository $candidatsRepository, $page, $nbr): Response

    {

        $nbCandidats = $candidatsRepository->count([]);
        $nbPages = ceil($nbCandidats / $nbr);
        $candidats = $candidatsRepository->findBy([], [], $nbr, ($page - 1) * $nbr);
        // EventListener
        $listAllCandidatsEvent = new ListAllCandidatsEvent(count($candidats));
        $this->dispatcher->dispatch($listAllCandidatsEvent, ListAllCandidatsEvent::LIST_CANDIDAT_EVENT);
        
        return $this->render('candidats/index.html.twig', [
            'candidats' => $candidats,
            'isPaginated' => true,
            'nbPages' => $nbPages,
            'page' => $page,
            'nbr' => $nbr
        ]);
    }
}
