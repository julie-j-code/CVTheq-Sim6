<?php

namespace App\Events;

use App\Entity\Candidats;

use Symfony\Contracts\EventDispatcher\Event;

class ListAllCandidatsEvent extends Event
{

    const LIST_CANDIDAT_EVENT = 'pagination';

    public function __construct(private int $nbCandidats){}

    public function getListCandidat(): int {
        return $this->nbCandidats;
    }

}