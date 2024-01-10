<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ArticleRepository $rep): Response
    {
        $produit = $rep->find(2);
        return $this->render('produit.html.twig', [
            'produit' => $produit,
        ]);
    }
}
