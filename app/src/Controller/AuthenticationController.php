<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AuthenticationController extends AbstractController
{
    #[Route('/', name: 'app_authenticate')]
    public function authenticate(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')){
            $email = $request->request->get("email");
            if (filter_var($email, FILTER_VALIDATE_EMAIL) ){
                $userRepository = $entityManager->getRepository(User::class);
                $count = $userRepository->count(['email' => $email]);
                $session = $request->getSession();
                $session->set("email", $email);
                $session->set("permission", false);
                if ($count == 1)
                    return $this->redirectToRoute("app_login");
                return $this->redirectToRoute("app_register");
            }else{
                 $this->addFlash("error", "\nEmail incorrecte");
            }
        }
        return $this->render('connexion/authenticate.html.twig', [
            'controller_name' => 'AuthenticationController',
        ]);
    }

}
