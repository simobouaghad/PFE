<?php

namespace App\Form;

use App\Entity\Professeur;
use App\Entity\Centre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class ProfesseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('sexe', ChoiceType::class, [
                'placeholder' => 'choisir le sexe',
                'choices'  => [ 
                    'homme' => 'homme',
                    'femme' => 'femme',
                ],
            ])

            ->add('CIN')
            ->add('telephone')
            ->add('adresse')
            ->add('email')
            ->add('image', FileType::class, [
                'label' => 'Brochure (PDF file)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('password')
            ->add('centre', EntityType::class, [
                'class' => Centre::class,
                'placeholder' => 'choisir un centre',
                'choice_label' => 'name',
            ])
            ->add('salary')
            ->add('planning', FileType::class, [
                'label' => 'Brochure (PDF file)',
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}
