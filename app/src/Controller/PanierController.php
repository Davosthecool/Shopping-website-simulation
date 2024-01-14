<?php

namespace App\Controller;

use Amp\Http\Client\Request;
use App\Entity\Panier;
use App\Repository\UserRepository;
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
    public function viderPanier(Request $request, UserRepository $userRepository): Response
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('app_accueil');
        $panier = $userRepository->find($this->getUser())->getPanier();
        $panier->viderContenu();
        return $this->redirectToRoute("app_panier");
    }
}
