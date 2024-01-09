<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use app\Entity\User;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(UserRepository $rep): Response
    {
        $users = $rep->findAll();
        return $this->render('test/index.html.twig', [
            'controller_name' => "name",
            'list_users' => $users,
        ]);
    }
}
