<?php

namespace App\Form;

use App\Entity\Directeur;
use App\Entity\Ville;
use App\Entity\Centre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class DirecteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')

            ->add('image', FileType::class, [
                'label' => 'Brochure (PDF file)',
                'mapped' => false,
                'required' => false,
            ])

            ->add('sexe', ChoiceType::class, [
                'placeholder' => 'choisir le sexe',
                'choices'  => [ 
                    'homme' => 'homme',
                    'femme' => 'femme',
                ],
            ])

            ->add('CIN')
            ->add('telephone')
            ->add('email')
            ->add('adresse')

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
            ->add('password')
            ->add('salary')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Directeur::class,
        ]);
    }
}
