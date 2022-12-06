<?php

namespace App\Form;

use App\Entity\Sale;
use App\Entity\Ville;
use App\Entity\Centre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class SaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')

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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sale::class,
        ]);
    }
}
