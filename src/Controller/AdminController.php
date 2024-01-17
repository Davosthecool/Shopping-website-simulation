<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Exemplaire;
use App\Entity\User;
use App\Form\AdminAddArticleType;
use App\Form\AdminAddExemplaireType;
use App\Form\AdminAddUserType;
use App\Repository\ArticleRepository;
use App\Repository\ExemplaireRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\New_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private UserRepository $uRep;

    public function __construct(UserRepository $uRep) {
        $this->uRep = $uRep;
    }
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $user = $this->uRep->find($this->getUser());


        return $this->render('admin/index.html.twig', [

        ]);
    }

    #[Route('/admin/user', name: 'app_admin_user')]
    public function user(UserRepository $uRep, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->uRep->find($this->getUser());
        if ($user==null|| !in_array('ROLE_ADMIN',$user->getRoles()) ){
            return $this->redirectToRoute('app_accueil');
        }

        $user = New User();
        $addUserForm = $this->createForm(AdminAddUserType::class, $user);
        $addUserForm->handleRequest($request);
        if ($addUserForm->isSubmitted() && $addUserForm->isValid()) {
            $user->setRoles(array("user"));
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $addUserForm->get('password')->getData()
                )
            );

            $user->setEmail(trim($user->getEmail()));
            $user->setNom(trim($user->getNom()));
            $user->setPrenom(trim($user->getPrenom()));
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('admin/user.html.twig', [
            'users' => $uRep->findAll(),
            'addUserForm' => $addUserForm
        ]);
    }

    #[Route('/admin/user/{user_id}', name: 'app_admin_user_remove')]
    public function userDelete(int $user_id, UserRepository $uRep, EntityManagerInterface $entityManager): Response
    {
        $user = $this->uRep->find($this->getUser());
        if ($user==null|| !in_array('ROLE_ADMIN',$user->getRoles()) ){
            return $this->redirectToRoute('app_accueil');
        }

        $entityManager->remove($uRep->find($user_id));
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_user');
    }



    #[Route('/admin/article', name: 'app_admin_article')]
    public function article(ArticleRepository $aRep, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->uRep->find($this->getUser());
        if ($user==null|| !in_array('ROLE_ADMIN',$user->getRoles()) ){
            return $this->redirectToRoute('app_accueil');
        }


        $addProduitForm = $this->createForm(AdminAddArticleType::class, new Article);
        $addProduitForm->handleRequest($request);
        if ($addProduitForm->isSubmitted() && $addProduitForm->isValid()) {
            $entityManager->persist($addProduitForm->getData());
            $entityManager->flush();
        }
        return $this->render('admin/article.html.twig', [
            'articles' => $aRep->findAll(),
            'addProduitForm' => $addProduitForm
        ]);
    }

    #[Route('/admin/article/{article_id}', name: 'app_admin_article_remove')]
    public function articleDelete(int $article_id, ArticleRepository $aRep, EntityManagerInterface $entityManager): Response
    {
        $user = $this->uRep->find($this->getUser());
        if ($user==null|| !in_array('ROLE_ADMIN',$user->getRoles()) ){
            return $this->redirectToRoute('app_accueil');
        }

        $entityManager->remove($aRep->find($article_id));
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_article');
    }



    #[Route('/admin/exemplaire', name: 'app_admin_exemplaire')]
    public function exemplaire(ExemplaireRepository $eRep, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->uRep->find($this->getUser());
        if ($user==null|| !in_array('ROLE_ADMIN',$user->getRoles()) ){
            return $this->redirectToRoute('app_accueil');
        }

        $addExemplaireForm = $this->createForm(AdminAddExemplaireType::class, new Exemplaire);
        $addExemplaireForm->handleRequest($request);
        if ($addExemplaireForm->isSubmitted() && $addExemplaireForm->isValid()) {
            $entityManager->persist($addExemplaireForm->getData());
            $entityManager->flush();
        }
        return $this->render('admin/exemplaire.html.twig', [
            'exemplaires' => $eRep->findAll(),
            'addExemplaireForm' => $addExemplaireForm
        ]);
    }

    #[Route('/admin/exemplaire/{exemplaire_id}', name: 'app_admin_exemplaire_remove')]
    public function exemplaireDelete(int $exemplaire_id, ExemplaireRepository $eRep, EntityManagerInterface $entityManager): Response
    {
        $user = $this->uRep->find($this->getUser());
        if ($user==null|| !in_array('ROLE_ADMIN',$user->getRoles()) ){
            return $this->redirectToRoute('app_accueil');
        }
        
        $entityManager->remove($eRep->find($exemplaire_id));
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_exemplaire');
    }
}
