<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index() : Response
    {
        if (!$this->getUser())
            return $this->redirectToRoute('app_login');
        return $this->redirectToRoute('app_infos_profil');
    }
    #[Route('/profil/infos', name: 'app_infos_profil')]
    public function infos_perso(): Response
    {
        if (!$this->getUser())
            return $this->redirectToRoute('app_login');
        return $this->render('interface_client/infos_perso.html.twig');
    }

    #[Route('/profil/historique-commandes', name: 'app_historique_commandes')]
    public function historiqueTransactions(): Response
    {
        if (!$this->getUser())
            return $this->redirectToRoute('app_login');
        return $this->render('interface_client/historique_transactions.html.twig');
    }
}