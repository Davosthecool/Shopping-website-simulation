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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ProfilFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'attr' => ['autocomplete' => false],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre email',
                    ]),
                    new Email([
                        'message' => 'E-mail incorrect'
                    ])
                ]
            ])
            ->add('nom', null,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom',
                    ]),
                ]
            ])
            ->add('prenom', null,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un prénom',
                    ]),
                ]
            ])
            ->add('sexe', ChoiceType::class,[
                'choices' => [
                    'Monsieur' => 'H',
                    'Madame' => 'F'
                ],
                'data' => 'H',
                'expanded' => true,
            ])
            ->add('adresse', TextType::class, [
                'required' => false,
            ])
            ->add('tel', TextType::class, [
                'required'=>false,
                'constraints'=> [
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Veuillez entrez un numéro correcte'
                    ]),
                    new Length([
                        'max' => 12,
                        'maxMessage' => '12 chiffres max'
                    ])
                ]
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
