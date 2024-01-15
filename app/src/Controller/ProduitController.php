<?php

namespace App\Controller;
use App\Entity\Exemplaire;
use App\Form\AddProduitType;
use App\Form\ResearchType;
use App\Repository\ArticleRepository;
use App\Repository\ExemplaireRepository;
use App\Repository\UserRepository;
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
        $researchForm = $this->createForm(ResearchType::class);
        $researchForm->handleRequest($request);
        if ($researchForm->isSubmitted() && $researchForm->isValid()) {
            return $this->render('accueil.html.twig', [
                'articles' => $Arep->findByNomContains(explode(' ',$researchForm->get('recherche')->getData() )),
                'researchForm' => $researchForm
            ]);
        }

        $produit = $Arep->find($produit_id);
        $addProduitForm = $this->createForm(AddProduitType::class, new Exemplaire(), ['produit' => $produit]);
        $addProduitForm->handleRequest($request);
        
        if ($addProduitForm->isSubmitted() && $addProduitForm->isValid()) {

            $exemplaire = $Erep->findOneBy(['taille' => $addProduitForm->get('taille')->getData(), 'couleur' => $addProduitForm->get('couleur')->getData(), 'panier' => null]);
            if ($exemplaire == null){
                return $this->render('produit.html.twig', [
                    'produit' => $produit,
                    'addproduitForm' => $addProduitForm->createView(),
                    'researchForm' => $researchForm
                ]);
            }

            $user = $this->getUser();
            if ($user!=null){
                $panier = $Urep->find($user)->getPanier();
                $panier->

                $entityManager->persist($panier);
                $entityManager->flush();

                return $this->render('produit.html.twig', [
                    'produit' => $produit,
                    'addproduitForm' => $addProduitForm->createView(),
                    'researchForm' => $researchForm
                ]);
            }else{
                return $this->redirectToRoute('app_login');
            }
            
        }
        return $this->render('produit.html.twig', [
            'produit' => $produit,
            'addproduitForm' => $addProduitForm->createView(),
            'researchForm' => $researchForm
        ]);
    }
}
