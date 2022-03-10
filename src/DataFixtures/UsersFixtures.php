<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UsersFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}
    
    public function load(ObjectManager $manager): void
    {
        $admin1 = new Users();
        $admin1->setEmail('admin@gmail.com');
        $admin1->setPassword($this->hasher->hashPassword($admin1,'admin'));
        $admin1->setRoles(['ROLE_ADMIN']);
        $admin2 = new Users();
        $admin2->setEmail('admin2@gmail.com');
        $admin2->setPassword($this->hasher->hashPassword($admin2, 'admin'));
        $admin2->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin1);
        $manager->persist($admin2);
        for ($i=1; $i<=5;$i++) {
            $users = new Users();
            $users->setEmail("user$i@gmail.com");
            $users->setPassword($this->hasher->hashPassword($users,'user'));
            $manager->persist($users);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['users'];
    }

}
