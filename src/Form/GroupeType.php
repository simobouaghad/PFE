<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Groupe;
use App\Entity\Centre;
use App\Entity\SousCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class GroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')

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

            ->add('souscategory', EntityType::class, [
                'class' => SousCategory::class,
                'placeholder' => 'choisir une sous categorie',
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
