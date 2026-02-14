<?php

namespace App\Controller\Admin;

use App\Repository\MedecinRepository;
use App\Repository\PatientRepository;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminDashboardController extends AbstractController
{
    #[Route('/', name: 'admin_dashboard_index')]
    public function index(
        PatientRepository $patientRepository,
        RendezVousRepository $rendezVousRepository,
        MedecinRepository $medecinRepository
    ): Response {
        $totalPatients = $patientRepository->count([]);
        $totalMedecins = $medecinRepository->count([]);

        // Logic for today's appointments
        $rdvAujourdhui = $rendezVousRepository->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.date = :today')
            ->setParameter('today', new \DateTime('today'))
            ->getQuery()
            ->getSingleScalarResult();

        // Logic for upcoming appointments
        $rdvAVenir = $rendezVousRepository->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.date > :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('admin/dashboard/index.html.twig', [
            'total_patients' => $totalPatients,
            'rdv_aujourdhui' => $rdvAujourdhui,
            'total_medecins' => $totalMedecins,
            'rdv_a_venir' => $rdvAVenir,
        ]);
    }
}
