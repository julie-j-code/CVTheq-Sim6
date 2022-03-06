<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Jobs;

class JobsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $data = [
            "Data scientist",
            "Statisticien",
            "Analyste cyber-sécurité",
            "Médecin ORL",
            "Échographiste",
            "Mathématicien",
            "Ingénieur logiciel",
            "Analyste informatique",
            "Pathologiste du discours / langage",
            "Actuaire",
            "Ergothérapeute",
            "Directeur des Ressources Humaines",
            "Hygiéniste dentaire "
        ];

        for ($i=0; $i< count($data); $i++){
            $job=new Jobs();
            $job->setDesignation($data[$i]);
            $manager->persist($job);
        }

        $manager->flush();
    }
}
