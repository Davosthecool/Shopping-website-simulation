<?php

namespace App\Controller;

use App\Form\ResearchType;
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
    public function index(ArticleRepository $articleRepository, UserRepository $userRepository, Request $request): Response
    {
        $user = $this->getUser();
        if ($user!=null){
            $user = $userRepository->find($user);
        }
        $researchForm = $this->createForm(ResearchType::class);
        $researchForm->handleRequest($request);
        if ($researchForm->isSubmitted() && $researchForm->isValid()) {
            $recherche = explode(' ',$researchForm->get('recherche')->getData());

            foreach ([...$articleRepository->findByNomContains($recherche),...$articleRepository->findByTags($recherche)] as $entity) {
                $id = $entity->getId(); // Remplacez par la méthode qui retourne l'identifiant unique de votre entité
                if (!isset($uniqueEntities[$id])) {
                    $articles[$id] = $entity;
                }
            }

            if (isset($articles)){
                return $this->render('accueil.html.twig', [
                    'articles' => $articles,
                    'researchForm' => $researchForm,
                    'user' => $user
                ]);
            }

            return $this->render('accueil.html.twig', [
                'articles' => array(),
                'researchForm' => $researchForm,
                'user' => $user
            ]);

        }

        return $this->render('accueil.html.twig', [
            'articles' => $articleRepository->findAll(),
            'researchForm' => $researchForm,
            'user' => $user
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
    
    #[Route('/accueil/cible/{cible}', name: 'app_accueil_cible')]
    public function indexByCategorie(string $cible, ArticleRepository $articleRepository, Request $request): Response
    {
        $researchForm = $this->createForm(ResearchType::class);
        $researchForm->handleRequest($request);
        if ($researchForm->isSubmitted() && $researchForm->isValid()) {
            return $this->render('accueil.html.twig', [
                'articles' => $articleRepository->findByNomContains(explode(' ',$researchForm->get('recherche')->getData() )),
                'researchForm' => $researchForm
            ]);
        }

        return $this->render('accueil.html.twig', [
            'articles' => $articleRepository->findByCible($cible),
            'researchForm' => $researchForm
        ]);
    }

    #[Route('/accueil/tag/{tag}', name: 'app_accueil_tag')]
    public function indexByTag(string $tag, ArticleRepository $articleRepository, Request $request): Response
    {
        $researchForm = $this->createForm(ResearchType::class);
        $researchForm->handleRequest($request);
        if ($researchForm->isSubmitted() && $researchForm->isValid()) {
            return $this->render('accueil.html.twig', [
                'articles' => $articleRepository->findByNomContains(explode(' ',$researchForm->get('recherche')->getData() )),
                'researchForm' => $researchForm
            ]);
        }

        return $this->render('accueil.html.twig', [
            'articles' => $articleRepository->findByTags([$tag]),
            'researchForm' => $researchForm
        ]);
    }

}
