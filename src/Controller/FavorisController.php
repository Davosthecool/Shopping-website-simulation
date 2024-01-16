<?php

namespace App\Controller;

use Amp\Http\Client\Request;
use App\Entity\Favoris;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


class FavorisController extends AbstractController
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

    #[Route('/favoris', name: 'app_favoris')]
    public function index(UserRepository $userRepository): Response
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('app_login');
        $favoris = $userRepository->find($this->getUser())->getFavoris();
        return $this->render('favoris.html.twig', [
            "favoris" => $favoris,
        ]);
    }
}