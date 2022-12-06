<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Etudiant;
use App\Entity\Session;
use App\Entity\Ville;
use App\Entity\Centre;
use App\Entity\Groupe;
use App\Entity\Methdepay;
use App\Entity\Payement;
use App\Entity\SousCategory;
use App\Repository\SessionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class EtudiantType extends AbstractType
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
            
            ->add('nompere')
            ->add('prenompere')
            ->add('CNIpere')
            ->add('telephone')
            ->add('adresse')

            ->add('image', FileType::class, [
                'label' => 'Brochure (PDF file)',
                'mapped' => false,
                'required' => false,
            ])

            ->add('email')
            ->add('password')

            ->add('annee', EntityType::class, [
                'class' => Session::class,
                'placeholder' => 'choisir la session',
                'choice_label' => 'name',
                'query_builder' => function(SessionRepository $sessionRepository) {
                    return $sessionRepository->createQueryBuilder('sessions')->orderBy('sessions.name', 'DESC');
                }
            ])

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

            ->add('methdepay', EntityType::class, [
                'class' => Methdepay::class,
                'placeholder' => 'choisir une méthode de payement',
                'choice_label' => 'methode',
            ])

            ->add('payement', EntityType::class, [
                'class' => Payement::class,
                'placeholder' => 'choisir le prix',
                'choice_label' => 'prix',
            ])

            ->add('cne')
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
