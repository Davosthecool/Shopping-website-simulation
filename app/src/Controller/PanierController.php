<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('app_login');
        $panier = ($this->getUser());
        return $this->render('panier/index.html.twig', []);
    }
}
