<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('accueil.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'app_accueil_redirect')]
    public function redirect_accueil() : Response{
       return $this->redirectToRoute('app_accueil');
    }
}
