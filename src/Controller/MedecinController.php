<?php

namespace App\Controller;

use App\Repository\MedecinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MedecinController extends AbstractController
{
    #[Route('/medecins', name: 'app_medecin')]
    public function index(MedecinRepository $medecinRepository): Response
    {
        $medecins = $medecinRepository->findAll();

        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecins,
        ]);
    }
}

