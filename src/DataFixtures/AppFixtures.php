<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct (UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $chris = new User($this->passwordHasher);
        $chris->setUsername("N0tchris")->setPassword("123")->setRoles(["ROLE_USER","ROLE_ADMIN"]);
        // $product = new Product();
        $manager->persist($chris);        
         
         $jonathan = new User($this->passwordHasher);
        $jonathan->setUsername("hsdudoio")->setPassword("123fhg66");
        // $product = new Product();
         $manager->persist($jonathan);

        $manager->flush();
    }
}
