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
    #[Route('/produit', name: 'app_produit')]
    public function index(ArticleRepository $Arep, ExemplaireRepository $Erep, UserRepository $Urep, Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = $Arep->find(1);

        $exemplaire = new Exemplaire();
        $form = $this->createForm(AddProduitType::class, $exemplaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $request->getSession();

            // $exemplaire = $form->getData();
            // $exemplaire->setType($produit);// probleme de dulication d'exemplaires dans bdd
            // $entityManager->persist($exemplaire);//pour l'instant on cree un exemplaire
            // $entityManager->flush();//le but est d'avoir des esemplaires et de se baser sur le stock
            // pour afficher les tailles/couleurs possibles puis de les retirer du stock quand ils sont achetes
            //doit rajouter le fait de mettre dans le panier
            $exemplaire = $Erep->findOneBy(['taille' => $form->get('taille')->getData(), 'couleur' => $form->get('couleur')->getData(), 'panier' => null]);
            if ($exemplaire == null){
                return $this->render('produit.html.twig', [
                    'produit' => $produit,
                    'addproduitForm' => $form->createView(),
                ]);
            }
            $panier = $Urep->findOneBy(['email' => $session->get('email')])->getPanier();
            $panier->addContenu($exemplaire);

            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->render('produit.html.twig', [
                'produit' => $produit,
                'addproduitForm' => $form->createView(),
            ]);
        }
        return $this->render('produit.html.twig', [
            'produit' => $produit,
            'addproduitForm' => $form->createView(),
        ]);
    }

    #[Route('/produit/add', name: 'app_produit_add')]
    public function add(ArticleRepository $rep): Response
    {
        $produit = $rep->find(2);
        return $this->render('produit.html.twig', [
            'produit' => $produit,
        ]);
    }


}
