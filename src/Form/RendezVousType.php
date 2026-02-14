<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Repository\MedecinRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email; // Added

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date du Rendez-vous :',
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => function (Medecin $medecin) {
                    return $medecin->getNom() . ' (' . $medecin->getSpecialite() . ')';
                },
                'label' => 'Médecin',
            ])
            // ADDED: EntityType for Patient
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => function (Patient $patient) {
                    return $patient->getNom() . ' ' . $patient->getPrenom() . ' (' . $patient->getEmail() . ')';
                },
                'placeholder' => 'Sélectionnez un patient',
                'required' => true,
                'label' => 'Patient',
            ])
            ->add('heure', TimeType::class, [
                'label' => 'Heure du Rendez-vous :',
                'widget' => 'single_text',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
