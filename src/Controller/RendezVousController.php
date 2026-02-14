<?php

namespace App\Controller;

use App\Entity\Patient; 
use App\Entity\RendezVous;
use App\Form\PublicRendezVousType; 
use App\Repository\PatientRepository; 
use App\Repository\RendezVousRepository; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RendezVousController extends AbstractController
{
    #[Route('/rendez-vous', name: 'app_rendezvous_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        PatientRepository $patientRepository, 
        RendezVousRepository $rendezVousRepository
    ): Response {
        $rendezVous = new RendezVous();
        $form = $this->createForm(PublicRendezVousType::class, $rendezVous); 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patientDataFromForm = $rendezVous->getPatient();
            $patient = $patientRepository->findOneBy(['email' => $patientDataFromForm->getEmail()]);

            if ($patient) {
                $patient->setNom($patientDataFromForm->getNom());
                $patient->setPrenom($patientDataFromForm->getPrenom());
                $patient->setTelephone($patientDataFromForm->getTelephone());
                $patient->setAdresse($patientDataFromForm->getAdresse());
                $rendezVous->setPatient($patient);
            } else {
                $patient = $patientDataFromForm;
            }

           
            $existing = $rendezVousRepository->findOneBy([
                'medecin' => $rendezVous->getMedecin(),
                'date' => $rendezVous->getDate(),
                'heure' => $rendezVous->getHeure(),
            ]);

            if ($existing) {
                $this->addFlash('error', 'Ce créneau est déjà réservé. Veuillez choisir une autre date ou heure.');
                return $this->render('rendezvous/new.html.twig', [
                    'form' => $form,
                ]);
            }

            // 6. Persist and flush
            $entityManager->persist($patient); // Persist patient (new or updated)
            $entityManager->persist($rendezVous);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Merci ' . $patient->getNom() . ' ' . $patient->getPrenom() .
                ', votre rendez-vous avec Dr. ' . $rendezVous->getMedecin()->getNom() .
                ' le ' . $rendezVous->getDate()->format('d/m/Y') .
                ' à ' . $rendezVous->getHeure()->format('H:i') .
                ' a été enregistré.'
            );

            return $this->redirectToRoute('app_rendezvous_new');
        }

        return $this->render('rendezvous/new.html.twig', [
            'form' => $form,
        ]);
    }
}
