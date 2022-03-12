<?php

use App\Entity\Candidats;
use Symfony\Contracts\EventDispatcher\Event;


class AddCandidatEvent extends Event
{

    const ADD_CANDIDAT_EVENT = 'candidats-add';

    public function __construct(private Candidats $candidat) {}

    public function getCandidat(): Candidats {
        return $this->candidat;
    }


}