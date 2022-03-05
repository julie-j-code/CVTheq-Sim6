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
    public function index(Request $request, CandidatsRepository $candidatsRepository): Response

    {

        $candidats = $candidatsRepository->findAll();
        return $this->render('candidats/index.html.twig', [
            'candidats'=>$candidats]);

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
}
