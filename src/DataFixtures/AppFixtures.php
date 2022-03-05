<?php

namespace App\DataFixtures;

use App\Entity\Candidats;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $candidat = new Candidats();
            $candidat->setLastname($faker->lastName);
            $candidat->setFirstname($faker->firstName);
            $candidat->setAge(mt_rand(22, 50));
            $manager->persist($candidat);
        }


        $manager->flush();
    }




    
}
