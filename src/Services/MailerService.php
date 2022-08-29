<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private $replyTo;
    public function __construct(private MailerInterface $mailer, $replyTo) {
        $this->replyTo = $replyTo;
    }

    // pour m'avertir (avertir un administrateur) à l'inscription d'un candidat

    public function sendEmail(
        $to = 'jeannet.julie@gmail.com',
        $content = '<p>Un candidat vient de s\'inscrire!</p>',
        $subject = 'Nouveau candidat!'
    ): void
    {
        $email = (new Email())
            ->from('jeannet.julie@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo($this->replyTo)
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
//            ->text('Sending emails is fun again!')
            ->html($content);
             $this->mailer->send($email);
        // ...
    }


    public function contactCandidat(
    // à faire
        $content , $from, $to, $subject
    ): void
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo($this->replyTo)
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
//            ->text('Sending emails is fun again!')
            ->html($content);
             $this->mailer->send($email);
        // ...
    }

    

}