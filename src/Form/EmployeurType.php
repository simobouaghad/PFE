<?php

namespace App\Form;

use App\Entity\Employeur;
use App\Entity\Ville;
use App\Entity\Centre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class EmployeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')

            ->add('type', ChoiceType::class, [
                'placeholder' => 'choisir type d\'employeur',
                'choices'  => [ 
                    'femme de minage' => 'femme de minage',
                    'guardian' => 'guardian',
                ],
            ])

            ->add('sexe', ChoiceType::class, [
                'placeholder' => 'choisir le sexe',
                'choices'  => [ 
                    'homme' => 'homme',
                    'femme' => 'femme',
                ],
            ])

            ->add('image', FileType::class, [
                'label' => 'Brochure (PDF file)',
                'mapped' => false,
                'required' => false,
            ])

            ->add('telephone')
            ->add('CIN')
            ->add('email')
            ->add('adresse')
            ->add('password')

            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'placeholder' => 'choisir une ville',
                'choice_label' => 'name',
            ])

            ->add('centre', EntityType::class, [
                'class' => Centre::class,
                'placeholder' => 'choisir un centre',
                'choice_label' => 'name',
            ])
            ->add('salary')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employeur::class,
        ]);
    }
}
