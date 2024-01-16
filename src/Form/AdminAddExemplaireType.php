<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Exemplaire;
use App\Entity\Panier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminAddExemplaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('taille', ChoiceType::class,[
                'placeholder' => 'Choisissez une taille',
                'choices' => [
                    'XS' => 'XS',
                    'S' => 'S',
                    'M' => 'M',
                    'L' => 'L',
                    'XL' => 'XL'
                ]
            ])
            ->add('couleur', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez saisir la couleur de l'exemplaire",
                    ])
                ]
            ])
            ->add('type', EntityType::class, [
                'class' => Article::class,
                'choice_label' => 'nom',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Créer exemplaire'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exemplaire::class,
        ]);
    }
}
