<?php

namespace App\Controller;

use Amp\Http\Client\Request;
use App\Entity\Exemplaire;
use App\Entity\Panier;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


class PanierController extends AbstractController
{
    private $csrfTokenManager;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    private function generateCsrfToken(string $tokenId): string
    {
        return $this->csrfTokenManager->getToken($tokenId)->getValue();
    }


    #[Route('/panier', name: 'app_panier')]
    public function index(UserRepository $userRepository): Response
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('app_login');
        $panier = $userRepository->find($this->getUser())->getPanier();
        return $this->render('panier/index.html.twig', [
            "panier" => $panier->getContenu(),
        ]);
    }


    #[Route('/panier/vider', name:'app_vider_panier')]
    public function viderPanier(EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('app_accueil');
        $panier = $entityManager->getRepository(User::class)->find($this->getUser())->getPanier();
        if ($panier->getNbArticles() == 0){
            return $this->redirectToRoute('app_acceuil');
        }
        $panier->viderToutContenu();
        $entityManager->persist($panier);
        $entityManager->flush();
        return $this->redirectToRoute("app_panier");
    }

    #[Route('/panier/retirer/{produit_id}', name:'app_retirer_article', requirements: ['produit_id'=>'\d+'])]
    public function retirerArticle(int $produit_id, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('app_accueil');
        $panier = $entityManager->getRepository(User::class)->find($this->getUser())->getPanier();
        if ($panier->getNbArticles() == 0){
            return $this->redirectToRoute('app_accueil');
        }
        $exemplaire = $entityManager->getRepository(Exemplaire::class)->find($produit_id);
        $panier->removeContenu($exemplaire);
        $entityManager->persist($panier);
        $entityManager->flush();
        return $this->render('panier/index.html.twig', [
            "panier" => $panier->getContenu(),
        ]);
    }

    #[Route('/panier/valider-panier', name:'app_valider_panier')]
    public function validerPanier(EntityManagerInterface $entityManager):Response
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('app_accueil');
        $panier = $entityManager->getRepository(User::class)->find($this->getUser())->getPanier();
        if ($panier->getNbArticles() == 0){
            return $this->redirectToRoute('app_accueil');
        }
        $panier->viderToutContenu();
        $entityManager->persist($panier);
        $entityManager->flush();
        $this->addFlash("success","Achat réussi");
        return $this->redirectToRoute('app_accueil', [""]);
    }


}
