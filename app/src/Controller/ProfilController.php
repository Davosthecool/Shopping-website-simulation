<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ProfilFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{



    #[Route('/profil', name:'app_profil')]
    #[Route('/profil/infos', name: 'app_infos_profil')]
    public function infos_perso(Request $request,  EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser())
            return $this->redirectToRoute('app_login');
        $user = $entityManager->getRepository(User::class)->find($this->getUser());
        $form = $this->createForm(ProfilFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if (!$form->isValid()){
                $this->addFlash('error', 'Un ou plusieurs champs sont invalides.');
                return $this->render('connexion/register.html.twig', [
                    'registrationForm' => $form->createView(),
                ]);
            }

            $user->setEmail(trim($user->getEmail()));
            $user->setNom(trim($user->getNom()));
            $user->setPrenom(trim($user->getPrenom()));

            $entityManager->flush();
            $this->addFlash("success","Changement effectué");
        }
        return $this->render('interface_client/infos_perso.html.twig',[
            "profilForm" => $form->createView()
        ]);
    }

    #[Route('/profil/changer-mot-de-passe', name: 'app_change_password')]
    public function changePassword(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher) : Response
    {
        if (!$this->getUser())
            return $this->redirectToRoute('app_login');
        $user = $entityManager->getRepository(User::class)->find($this->getUser());
        $form = $this->createForm(ChangePasswordFormType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if (!$form->isValid()){
                $this->addFlash("error", "mot(s) de passe entré(s) incorrect(s)");
                return $this->render('interface_client/changer_mot_de_passe.html.twig',[
                    "changePassword" => $form->createView()
                ]);
            }
            if ($userPasswordHasher->isPasswordValid($user, $form->get('oldPassword')->getData())){
                $hashedPassword = $userPasswordHasher->hashPassword($user, $form->get('password')->getData());
                $user->setPassword($hashedPassword);
                $entityManager->flush();
                $this->addFlash("success","Mot de passe changé avec succés");
            }else{
                $this->addFlash("error", "ancien mot de passe incorrect (plus que 2 tentatives avant auto-destruction du compte)");
                return $this->render('interface_client/changer_mot_de_passe.html.twig',[
                    "changePassword" => $form->createView()
                ]);
            }

            return $this->redirectToRoute("app_infos_profil");
        }


        return $this->render('interface_client/changer_mot_de_passe.html.twig',[
            "changePassword" => $form->createView()
        ]);
    }

    #[Route('/profil/historique-commandes', name: 'app_historique_commandes')]
    public function historiqueTransactions(): Response
    {
        if (!$this->getUser())
            return $this->redirectToRoute('app_login');
        return $this->render('interface_client/historique_transactions.html.twig');
    }

    #[Route('/profil/bons-d-achat', name: 'app_bons-d-achat')]
        public function bonsAchat(): Response
        {
            if (!$this->getUser())
                return $this->redirectToRoute('app_login');
            return $this->render('interface_client/bons_achat.html.twig');
        }

    #[Route('/profil/support-client', name: 'app_support-client')]
            public function supportClient(): Response
            {
                if (!$this->getUser())
                    return $this->redirectToRoute('app_login');
                return $this->render('interface_client/support_client.html.twig');
            }
}
