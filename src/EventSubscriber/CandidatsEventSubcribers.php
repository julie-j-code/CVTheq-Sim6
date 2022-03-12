<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use App\Service\MailerService;
use App\Event\AddCandidatEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PersonneEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            AddCandidatEvent::ADD_CANDIDAT_EVENT => ['onAddCandidatEvent', 3000]
        ];
    }

    // on ne passe plus par service.yaml mais on définit ici même la méthode
    public function onAddCandidatEvent(AddCandidatEvent $event, MailerService $mailer) {
        $candidat = $event->getCandidat();
        $mailMessage = $candidat->getFirstname().' '.$candidat->getLastname()." a été ajouté avec succès";
        $this->logger->info("Souscription à l'évènement d'ajout : ".$candidat->getFirstname());
        $this->mailer->sendEmail(content: $mailMessage, subject: 'Mail sent from EventSubscriber');
    }
}