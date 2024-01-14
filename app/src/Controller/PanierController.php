<?php

namespace App\Controller;

use Amp\Http\Client\Request;
use App\Entity\Panier;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PanierController extends AbstractController
{
    private Panier|null $panier = null;

    #[Route('/panier', name: 'app_panier')]
    public function index(UserRepository $userRepository): Response
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('app_login');
        if ($this->panier == null)
            $this->panier = $userRepository->find($this->getUser())->getPanier();
        return $this->render('panier/index.html.twig', [
            "panier" => $this->panier->getContenu(),
        ]);
    }


    #[Route('/panier/vider', name:'app_vider_panier')]
    public function viderPanier(Request $request): Response
    {
        return $this->redirectToRoute("app_panier");
    }
}
