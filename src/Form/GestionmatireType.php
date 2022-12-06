<?php

namespace App\Form;

use App\Entity\Gestionmatire;
use App\Entity\Category;
use App\Entity\Centre;
use App\Entity\Groupe;
use App\Entity\Matire;
use App\Entity\Professeur;
use App\Entity\Session;
use App\Entity\SousCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class GestionmatireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('centre', EntityType::class, [
            'class' => Centre::class,
            'placeholder' => 'choisir un centre',
            'choice_label' => 'name',
        ])

        ->add('category', EntityType::class, [
            'class' => Category::class,
            'placeholder' => 'choisir une categorie',
            'choice_label' => 'name',
        ])

        ->add('sousCategory', EntityType::class, [
            'class' => SousCategory::class,
            'placeholder' => 'choisir une sous categorie',
            'choice_label' => 'name',
        ])

        ->add('groupe', EntityType::class, [
            'class' => Groupe::class,
            'placeholder' => 'choisir un groupe',
            'choice_label' => 'name',
        ])

        ->add('matire', EntityType::class, [
            'class' => Matire::class,
            'placeholder' => 'choisir une matière',
            'choice_label' => 'name',
        ])

        ->add('prof', EntityType::class, [
            'class' => Professeur::class,
            'placeholder' => 'choisir un professeur',
            'choice_label' => 'prenom',
        ])

        ->add('session', EntityType::class, [
            'class' => Session::class,
            'placeholder' => 'choisir une session',
            'choice_label' => 'name',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gestionmatire::class,
        ]);
    }
}
