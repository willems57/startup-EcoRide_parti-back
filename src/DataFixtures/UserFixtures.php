<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Avis;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements FixtureGroupInterface

    {
        public const USER_NB_TUPLES = 20;
    
        public function __construct(private UserPasswordHasherInterface $passwordHasher)
        {
        }
    
        public function load(ObjectManager $manager): void
        {
            $faker = Factory::create();
    
            $avis = new Avis();
        $manager->persist($avis);
            for ($i = 1; $i <= self::USER_NB_TUPLES; $i++) {
                $user = (new User())
                    ->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName())
                    ->setRoles($faker->Roles()) // Définition des rôles
                    ->setEmail($faker->unique()->safeEmail())
                    ->setAvis($avis)
                    ->setCreatedAt(new \DateTimeImmutable()); // Définir createdAt
    
                $user->setPassword($this->passwordHasher->hashPassword($user, 'password' . $i));
    
                $manager->persist($user);
            }
    
            $manager->flush();
        }
    
        public static function getGroups(): array
        {
            return ['independent'];
        }
    }