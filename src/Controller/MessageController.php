<?php

namespace App\Controller;

use App\Entity\Candidats;
use App\Form\MessageFormType;
use App\Services\MailerService;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    #[Route('/message/{id<\d+>}', name: 'message')]
    public function message(Request $request, MailerService $mailer, Candidats $candidat ): Response
    {
        
        $form= $this->createForm(MessageFormType::class);
        // on récupère l'identifiant de l'utilisateur(le recruteur) en cours
        $user=$this->getUser();
        // on peut laisser l'occasion au recruteur de fournir une autre adresse
        $from=$this->getUser()->getUserIdentifier();
        $form->handleRequest($request);
        $to=$candidat->getEmail();


        if ($form->isSubmitted() && $form->isValid()) {

            $mailMessage = $form->get('message')->getData();
            // si le from a changé entre temps parce que le client a fourni une autre adresse que son identifiant
            $from = $form->get('email')->getData();
            $subject = $form->get('subject')->getData();
            $fullName = $form->get('fullName')->getData();
            $newSubject = $subject." de la part de ".$fullName;
            // dd($newSubject);
            $this->addFlash(
                'success',
                'le candidat a bien été ajouté'
            );
            $mailer->contactCandidat($mailMessage, $from, $to, $newSubject);

            
            return $this->redirectToRoute('candidats');
        }

        
        return $this->render('message/index.html.twig', [
            'controller_name' => 'Contacter le candidat',
            'candidat_contact'=>$form->createView(),
            'user'=>$user,
            'from'=>$from
        ]);
    }
}
