<?php

namespace App\Form;

use App\Entity\Listnote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListnoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cne')
            ->add('ds1')
            ->add('ds2')
            ->add('ds3')
            ->add('ds4')
            ->add('activite')
            ->add('total')
            ->add('groupe')
            ->add('matire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listnote::class,
        ]);
    }
}
