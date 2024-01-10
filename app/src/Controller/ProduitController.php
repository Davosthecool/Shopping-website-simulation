<?php

namespace App\Controller;
use App\Entity\Exemplaire;
use App\Form\AddProduitType;
use App\Repository\ArticleRepository;
use App\Repository\ExemplaireRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ArticleRepository $Arep, ExemplaireRepository $Erep, PanierRepository $Prep, Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = $Arep->find(2);

        $exemplaire = new Exemplaire();
        $form = $this->createForm(AddProduitType::class, $exemplaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $exemplaire = $form->getData();
            $exemplaire->setType($produit);
            $entityManager->persist($exemplaire);//pour l'instant on cree un exemplaire
            $entityManager->flush();//le but est d'avoir des esemplaires et de se baser sur le stock
            // pour afficher les tailles/couleurs possibles puis de les retirer du stock quand ils sont achetes
            //doit rajouter le fait de mettre dans le panier
            $exemplaire = $Erep->findOneBy(['taille' => $form->get('taille')->getData(), 'couleur' => $form->get('couleur')->getData()]);

            return $this->redirectToRoute('app_register');
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
