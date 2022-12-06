<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Centre;
use App\Entity\Lessons;
use App\Entity\Matire;
use App\Entity\SousCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LessonsType extends AbstractType
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

            ->add('matire', EntityType::class, [
                'class' => Matire::class,
                'placeholder' => 'choisir une la matière',
                'choice_label' => 'name',
            ])

            ->add('title')
            
            ->add('lesson', FileType::class, [
                'label' => 'Brochure (PDF file)',
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lessons::class,
        ]);
    }
}
