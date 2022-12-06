<?php

namespace App\Form;

use App\Entity\Matire;
use App\Entity\Category;
use App\Entity\Centre;
use App\Entity\SousCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class MatireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('coefficient')
            ->add('image', FileType::class, [
                'label' => 'Brochure (PDF file)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('description')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matire::class,
        ]);
    }
}
