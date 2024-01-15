<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Panier;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AdminAddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre email',
                    ]),
                    new Email([
                        'message' => 'E-mail incorrect'
                    ]),
                ]
            ])

            ->add('password', RepeatedType::class, [

                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => "Votre mot de passe doit être d'au moins 8 caractères ",
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('nom', null,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Zéèàôç\-\s]+$/u',
                        'message' => 'Nom incorrecte (pas de caractères spécials)'
                    ])
                ]
            ])
            ->add('prenom', null,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un prénom',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Zéèàôç\-\s]+$/u',
                        'message' => 'Prénom incorrecte (pas de caractères spécials)'
                    ])
                ]
            ])
            ->add('sexe', ChoiceType::class,[
                'placeholder' => "Indiquez le sexe de l'utilisateur",
                'choices' => [
                    'Monsieur' => 'H',
                    'Madame' => 'F'
                ],
                'expanded' => true,
            ])
            ->add('adresse', null,[
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez saisir l'adresse de l'utilisateur",
                    ])
                ]
            ])
            ->add('tel', TelType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez saisir le numéro de téléphone de l'utilisateur",
                    ])
                ]
            ])

            ->add('submit', SubmitType::class, ['label' => 'Créer Utilisateur'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
