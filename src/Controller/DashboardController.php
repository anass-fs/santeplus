<?php

namespace App\Controller;

use App\Repository\MedecinRepository;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(RendezVousRepository $rendezVousRepository, MedecinRepository $medecinRepository): Response
    {
        /** @var \App\Entity\Patient $patient */
        $patient = $this->getUser();

        if (!$patient) {
            // This should not happen if the user is granted ROLE_USER
            // but it's a good practice to check
            return $this->redirectToRoute('app_login');
        }

        $allRendezVous = $rendezVousRepository->findBy(['patient' => $patient], ['date' => 'ASC', 'heure' => 'ASC']);
        
        $prochainRendezVous = null;
        $now = new \DateTime();
        foreach ($allRendezVous as $rdv) {
            $rdvDateTime = new \DateTime($rdv->getDate()->format('Y-m-d') . ' ' . $rdv->getHeure()->format('H:i:s'));
            if ($rdvDateTime > $now) {
                $prochainRendezVous = $rdv;
                break;
            }
        }
        
        $nombreRendezVous = count($allRendezVous);
        $medecins = $medecinRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'patient' => $patient,
            'nombreRendezVous' => $nombreRendezVous,
            'prochainRendezVous' => $prochainRendezVous,
            'medecins' => $medecins,
            'allRendezVous' => $allRendezVous,
        ]);
    }
}
