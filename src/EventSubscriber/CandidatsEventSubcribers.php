<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use App\Services\MailerService;
use App\Event\AddCandidatEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PersonneEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private MailerService $mailer
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            AddCandidatEvent::ADD_CANDIDAT_EVENT => ['onAddCandidatEvent', 3000]
        ];
    }

    // on ne passe plus par service.yaml mais on définit ici même la méthode
    // méthode qu'on aurait pu coupler au controller, mais ce n'est  pas une  bonne pratique...
    public function onAddCandidatEvent(AddCandidatEvent $event) {
        $candidat = $event->getCandidat();
        $mailMessage = $candidat->getFirstname().' '.$candidat->getLastname()." a été ajouté avec succès";
        $this->logger->info("Souscription à l'évènement d'ajout : ".$candidat->getFirstname());
        // mail gmail reçu ok
        // $this->mailer->sendEmail(content: $mailMessage, subject: 'Mail sent from EventSubscriber');
    }
}