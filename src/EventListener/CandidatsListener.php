<?php 

namespace App\EventListener;

use AddCandidatEvent;
use Psr\Log\LoggerInterface;

class CandidatsListener{

public function __construct(private LoggerInterface $logger)
{
    $logger->info('logMessage');    
}
    

    public function onCandidatsAdd(AddCandidatEvent $event){
        $this->logger->debug("cc je suis entrain d'écouter l'evenement personne.add et une personne vient d'être ajoutée et c'est ". $event->getCandidat()->getFirstname());
    }

}