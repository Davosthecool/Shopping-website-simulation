<?php

namespace App\Controller;
use App\Entity\Exemplaire;
use App\Form\AddProduitType;
use App\Repository\ArticleRepository;
use App\Repository\ExemplaireRepository;
use App\Repository\PanierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\isNull;

class ProduitController extends AbstractController
{
    #[Route('/produit/{produit_id}', name: 'app_produit', requirements: ['produit_id'=>'\d+'])]
    public function index(int $produit_id, ArticleRepository $Arep, ExemplaireRepository $Erep, UserRepository $Urep, Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = $Arep->find($produit_id);
        $form = $this->createForm(AddProduitType::class, new Exemplaire(), ['produit' => $produit]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $request->getSession();

            $exemplaire = $Erep->findOneBy(['taille' => $form->get('taille')->getData(), 'couleur' => $form->get('couleur')->getData(), 'panier' => null]);
            if ($exemplaire == null){
                return $this->render('produit.html.twig', [
                    'produit' => $produit,
                    'addproduitForm' => $form->createView(),
                ]);
            }

            $user = $this->getUser();
            if ($user!=null){
                $panier = $Urep->find($user)->getPanier();
                $panier->addContenu($exemplaire);

                $entityManager->persist($panier);
                $entityManager->flush();

                return $this->render('produit.html.twig', [
                    'produit' => $produit,
                    'addproduitForm' => $form->createView(),
                ]);
            }else{
                return $this->redirectToRoute('app_login');
            }
            
        }
        return $this->render('produit.html.twig', [
            'produit' => $produit,
            'addproduitForm' => $form->createView(),
        ]);
    }
}
