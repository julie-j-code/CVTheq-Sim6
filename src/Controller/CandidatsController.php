<?php

namespace App\Controller;

use App\Entity\Candidats;
use App\Repository\CandidatsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidats')]

class CandidatsController extends AbstractController
{
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


    #[Route('/add', name: 'candidats_add')]
    public function addCandidat(ObjectManager $manager): Response
    // public function addCandidat(ManagerRegistry $doctrine): Response
    {

        $candidat = new Candidats();
        // $manager = $doctrine->getManager();
        $candidat->setAge(30);
        $candidat->setFirstname('caroline');
        $candidat->setLastname('laville');
        $manager->persist($candidat);
        $manager->flush();
        // return $this->render('candidats/index.html.twig', [
        //     'candidat'=>$candidat]);
    }

    #[Route('/update/{id}/{firstname}/{lastname}/{age}', name: 'candidats_update')]
    // public function updateCandidat(CandidatsRepository $candidatsRepository, $id, $firstname, $lastname,$age, ManagerRegistry $doctrine): Response
    public function updateCandidat(ManagerRegistry $doctrine,Candidats $candidat = null, $id, $firstname, $lastname,$age ): Response
    {

        // $candidat = $candidatsRepository->find($id);
        $manager = $doctrine->getManager();
        if($candidat){

            $candidat->setAge($age);
            $candidat->setFirstname($firstname);
            $candidat->setLastname($lastname);
            $manager->persist($candidat);
            $manager->flush();
            $this->addFlash(
               'success',
               'Le candidat a bien été mis à jour'
            );

        } else{

            $this->addFlash(
               'error',
               'La personne n\'existe pas'
            );
        }
 
        return $this->redirectToRoute('pagination');

    }



    #[Route('/pagination/{page?1}/{nbr?8}', name: 'pagination')]
    public function pagination(CandidatsRepository $candidatsRepository, $page, $nbr): Response

    {

        $nbCandidats=$candidatsRepository->count([]);
        $nbPages=ceil($nbCandidats/$nbr);
        $candidats = $candidatsRepository->findBy([],[],$nbr, ($page-1)*$nbr);
        return $this->render('candidats/index.html.twig', [
            'candidats' => $candidats,
            'isPaginated' => true,
            'nbPages' => $nbPages,
            'page' => $page,
            'nbr' => $nbr
        ]);
    }


}
