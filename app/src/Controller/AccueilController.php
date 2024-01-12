<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/accueil/{article_id}', name: 'accueil_add_favoris', requirements: ['article_id'=>'\d+'])]
    public function add_favoris(int $article_id,EntityManagerInterface $entityManager, UserRepository $userRepository, ArticleRepository $articleRepository, Request $request) : Response{
        $email = $request->getSession()->get('email');
        if ($email!=null){
            $user = $userRepository->getUserByEmail($email);
            $article = $articleRepository->find($article_id);
            $user->addFavori($article);
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_accueil');
    }
}
