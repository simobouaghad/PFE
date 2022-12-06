<?php

namespace App\Form;

use App\Entity\Listpayment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ListpaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('from_')
            ->add('to_')
            ->add('status', ChoiceType::class, [
                'placeholder' => 'choisir le sexe',
                'choices'  => [ 
                    'payée' => 'payée',
                    'non payée' => 'non payée',
                ],
            ])
            ->add('prix')
            ->add('methodepay', ChoiceType::class, [
                'placeholder' => 'payer par',
                'choices'  => [ 
                    'Carte bancaire' => 'Carte bancaire',
                    'Espéce' => 'Espéce',
                    'Chéque' => 'Chéque',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listpayment::class,
        ]);
    }
}
