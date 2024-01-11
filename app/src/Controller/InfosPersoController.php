<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfosPersoController extends AbstractController
{
    #[Route('/infos_perso', name: 'app_infos_perso')]
    public function infos_perso(): Response
    {
        return $this->render('interface_client/infos_perso.html.twig', [
            'controller_name' => 'InfoController',
        ]);
    }
}
