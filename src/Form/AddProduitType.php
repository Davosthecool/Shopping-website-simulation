<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Exemplaire;
use App\Repository\ExemplaireRepository;
use Doctrine\ORM\QueryBuilder;
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
        $taille_choices = array();
        foreach ($options['produit']->getTailles() as $taille){
            $taille_choices[$taille] = $taille;
        }
        $couleur_choices = array();
        foreach ($options['produit']->getCouleurs() as $couleur){
            $couleur_choices[$couleur] = $couleur;
        }
    
        $builder
        //doit rendre les choix dependant de la bdd
            ->add('taille', ChoiceType::class , [
                'placeholder' => 'Choisissez une taille',
                'choices' => $taille_choices       //$this->makeChoicesfor('taille'),
                ])

        //same
            ->add('couleur', ChoiceType::class , [
                'placeholder' => 'Choisissez une couleur',
                'choices' => $couleur_choices
            ])
            ->add('submit', SubmitType::class, ['label' => 'Ajouter au panier'])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exemplaire::class,
            'produit' => null
        ]);
    }
}
