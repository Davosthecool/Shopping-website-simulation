<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, ): Response
    {
        $session = $request->getSession();
        if (!$session->has("email") || $session->get("email") == null)
            return $this->redirectToRoute("app_authenticate");
        if ($session->get("permission"))
            return $this->redirectToRoute("app_test"); //à modifier

        if ($request->isMethod('POST')){
            $motDePasse = $request->request->get('password');
            $userRepository = $entityManager->getRepository(User::class);
            $utilisateur = $userRepository->findOneBy(['email' => $session->get('email')]);
            if ($userPasswordHasher->isPasswordValid($utilisateur, $motDePasse)){
                $session->set("permission", true);
                return $this->redirectToRoute("app_test");
            }else{
                $this->addFlash("error","Mot de passe incorrecte");
                return $this->render('connexion/login.html.twig', [
                    'controller_name' => 'LoginController',
                ]);
            }

        }



        return $this->render('connexion/login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
}
