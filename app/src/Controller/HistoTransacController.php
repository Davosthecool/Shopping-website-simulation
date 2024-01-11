<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoTransacController extends AbstractController
{
    #[Route('/historique_transactions', name: 'app_historique_transaction')]
    public function infos_perso(): Response
    {
        return $this->render('interface_client/historique_transactions.html.twig', [
            'controller_name' => 'InfoController',
        ]);
    }
}
