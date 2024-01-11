<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager,
                             UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator): Response
    {
        if ($this->getUser())
            return $this->redirectToRoute('app_test');
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $message = $this->verifierChamps($user);
            if (!$form->isValid() || $message != ""){
                $this->addFlash('error', 'Vérifiez si votre nom ou prénom ne compore pas de caractères spéciales (lettres spécials exclus et "-" exclus) tel que la ponctution ou de chiffre . 
                8 caractères minimum pour le mot de passe et il doit bien être réécrit dans le champ confirmer mot de passe');
                return $this->render('connexion/register.html.twig', [
                    'registrationForm' => $form->createView(),
                ]);
            }
            $user->setRoles(array("user"));
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }
        return $this->render('connexion/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    private function verifierChamps(User $user){
        $message = "";
        switch(true){
            case preg_match('/^[a-zA-Zéèàôç\-\s]+$/u', $user->getNom()) !== 1:
                $message = $message."Nom incorrecte (ponctuation, caractère spéciales sauf les lettres spéciales et espace, interdit )\n";
            case preg_match('/^[a-zA-Zéèàôç\-\s]+$/u', $user->getPrenom()) !== 1:
                $message = $message."Prenom incorrecte (ponctuation, caractère spéciales sauf les lettres spéciales et espace, interdit )\n";
        }
        return $message;
    }
}
