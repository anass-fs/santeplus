<?php

namespace App\DataFixtures;

use App\Entity\Medecin;
use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Créer un patient de test
        $patient = new Patient();
        $patient->setNom('Jean Test');
        $patient->setEmail('jean.test@example.com');
        $patient->setPassword(
            $this->passwordHasher->hashPassword(
                $patient,
                'password123'
            )
        );
        $patient->setRoles(['ROLE_USER']);
        $manager->persist($patient);

        // Créer quelques médecins
        $medecin1 = new Medecin();
        $medecin1->setNom('Dupont');
        $medecin1->setSpecialite('Cardiologie');
        $medecin1->setVille('Paris');
        $medecin1->setTelephone('0123456789');
        $manager->persist($medecin1);

        $medecin2 = new Medecin();
        $medecin2->setNom('Martin');
        $medecin2->setSpecialite('Dermatologie');
        $medecin2->setVille('Lyon');
        $medecin2->setTelephone('0987654321');
        $manager->persist($medecin2);

        $manager->flush();
    }
}