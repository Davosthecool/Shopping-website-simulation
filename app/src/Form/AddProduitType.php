<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Exemplaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        //doit rendre les choix dependant de la bdd
            ->add('taille', ChoiceType::class , [
                'choices' => [
                    'S' => 2,
                    'M' => 3,
                    'L' => 4
                ] 
            ])

        //same
            ->add('couleur', ChoiceType::class , [
                'choices' => [
                    'bleu' => 'bleu',
                    'vert' => 'vert'
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Ajouter au panier'])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exemplaire::class,
        ]);
    }
}
