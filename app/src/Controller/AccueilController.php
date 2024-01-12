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
        $user = $this->getUser();
        if ($user!=null){
            $user = $userRepository->find($user);
            $article = $articleRepository->find($article_id);
            if (!$user->addFavori($article)){
                $user->removeFavori($article);
            }
            $entityManager->persist($user);
            $entityManager->flush();
        }else{
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('app_accueil');
    }
}
