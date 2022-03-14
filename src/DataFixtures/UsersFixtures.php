<?php

namespace App\DataFixtures;

use App\Entity\Todos;
use App\Entity\Users;
use App\Repository\TodosRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;


class UsersFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private TodosRepository $todosRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("fr_FR");
        $admin1 = new Users();
        $admin1->setEmail('admin@gmail.com');
        $admin1->setPassword($this->hasher->hashPassword($admin1, 'admin'));
        $admin1->setRoles(['ROLE_SUPER_ADMIN']);
        $admin2 = new Users();
        $admin2->setEmail('admin2@gmail.com');
        $admin2->setPassword($this->hasher->hashPassword($admin2, 'admin'));
        $admin2->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin1);
        $manager->persist($admin2);

        for ($i = 1; $i <= 10; $i++) {
            $todos = new Todos;
            $todos->setName($faker->realText(15));
            $todos->setContent($faker->sentence(2));
            $manager->persist($todos);
            $manager->flush();
        }
        
        for ($i = 1; $i <= 5; $i++) {
            // $todos = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"];
            $todos = $this->todosRepository->findAll();
            $users = new Users();
            $users->setEmail("user$i@gmail.com");
            $users->setPassword($this->hasher->hashPassword($users, 'user'));
            $users->setPictureFilename('user.jpg');
            $randomInputIndex = rand(0, count($todos));
            $randomInputValue=$todos[$randomInputIndex];
            $users->setTodos($randomInputValue);
            $manager->persist($users);
            $manager->flush();
        }

        
    }

    // public static function getGroups(): array
    // {
    //     return ['users'];
    // }

}
