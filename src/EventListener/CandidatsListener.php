<?php

namespace App\EventListener;

use App\Events\AddCandidatEvent;
use App\Events\ListAllCandidatsEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;

class CandidatsListener
{

    public function __construct(private LoggerInterface $logger)
    {
    }


    public function onCandidatsAdd(AddCandidatEvent $event)
    {
        $this->logger->debug("cc je suis entrain d'écouter l'evenement personne-add et une personne vient d'être ajoutée et c'est " . $event->getCandidat()->getFirstname());
    }

    public function onPagination(ListAllCandidatsEvent $event)
    {
        $this->logger->debug("Le nombre de personne dans la base est " . $event->getListCandidat());
    }

    public function logKernelRequest(KernelEvent $event)
    {
        dd($event->getRequest());
    }
}
