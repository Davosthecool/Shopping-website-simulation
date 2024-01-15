<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AdminAddArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null,[
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez saisir le nom de l'article",
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Zéèàôç\-\s]+$/u',
                        'message' => 'Nom incorrecte (pas de caractères spéciaux)'
                    ])
                ]
            ])
            ->add('marque', null,[
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez saisir la marque de l'article",
                    ])
                ]
            ])
            ->add('prix', MoneyType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez saisir le prix de l'article",
                    ])
                ]
            ])
            ->add('cible', ChoiceType::class,[
                'placeholder' => 'Choisissez une cible',
                'choices' => [
                    'Homme' => 'H',
                    'Femme' => 'F',
                    'Enfant' => 'E',
                    'Autre/Aucun' => 'O'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez saisir la cible de l'article",
                    ])
                ]
            ])
            ->add('image', TextType::class,[
                'attr' => ['placeholder' => 'image.png'],
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez saisir l'image de l'article",
                    ])
                ]
            ])

            ->add('submit', SubmitType::class, ['label' => 'Créer article'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
