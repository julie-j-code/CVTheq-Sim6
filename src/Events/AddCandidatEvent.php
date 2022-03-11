<?php

use App\Entity\Candidats;
use Symfony\Component\EventDispatcher\GenericEvent;

$event = new GenericEvent($subject);
$dispatcher->dispatch($event, 'foo');

class AddCandidatEvent
{


    const ADD_CANDIDAT_EVENT = 'candidats-add';

    public function __construct(private Candidats $candidat) {}

    public function getCandidat(): Candidats {
        return $this->candidat;
    }

    // public function handler(GenericEvent $event)
    // {
    //     if ($event->getSubject() instanceof Foo) {
    //         // ...
    //     }
    // }
}