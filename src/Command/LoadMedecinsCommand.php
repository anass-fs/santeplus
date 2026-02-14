<?php

namespace App\Command;

use App\Entity\Medecin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-medecins',
    description: 'Charge les médecins de test dans la base de données',
)]
class LoadMedecinsCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Vérifier si des médecins existent déjà
        $existingMedecins = $this->entityManager->getRepository(Medecin::class)->findAll();
        if (count($existingMedecins) > 0) {
            $io->warning('Des médecins existent déjà dans la base de données.');
            return Command::SUCCESS;
        }

        // Créer les médecins
        $medecinsData = [
            [
                'nom' => 'Nizar kabbani',
                'specialite' => 'Médecin Généraliste',
                'ville' => 'Casablanca',
                'telephone' => '+212 600 112 233',
            ],
            [
                'nom' => 'Lhssen chouikhi',
                'specialite' => 'Cardiologue',
                'ville' => 'Casablanca',
                'telephone' => '+212 600 112 234',
            ],
            [
                'nom' => 'Lina Mansour',
                'specialite' => 'Dermatologue',
                'ville' => 'Casablanca',
                'telephone' => '+212 600 112 235',
            ],
        ];

        foreach ($medecinsData as $data) {
            $medecin = new Medecin();
            $medecin->setNom($data['nom']);
            $medecin->setSpecialite($data['specialite']);
            $medecin->setVille($data['ville']);
            $medecin->setTelephone($data['telephone']);
            
            $this->entityManager->persist($medecin);
        }

        $this->entityManager->flush();

        $io->success('Les médecins ont été chargés avec succès !');

        return Command::SUCCESS;
    }
}

