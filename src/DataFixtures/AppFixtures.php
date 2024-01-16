<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Exemplaire;
use App\Entity\User;
use App\Repository\ArticleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private Generator $faker;
    private ArticleRepository $articleRepository;
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(ArticleRepository $articleRepository, UserPasswordHasherInterface $userPasswordHasher){
        $this->faker = Factory::create('fr_FR');
        $this->articleRepository = $articleRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // Remplissage de la BD avec des Articles aléatoires
        $cibles=['H','F','E','O'];
        for ($i=0; $i<10; $i++){
            $product = new Article();
            $product->setNom($this->faker->words(4,true))
                ->setPrix(mt_rand(100,10000) / 100)
                ->setTailles([])
                ->setCouleurs([])
                ->setTags([])
                ->setCible($cibles[mt_rand(0,count($cibles)-1)])
                ->setMarque(null)
                ->setImage('image5.png');


            $manager->persist($product);
        }
        $manager->flush();

        // Remplissage de la BD avec des Exemplaires aléatoires
        $tailles = array('XS','S','M','L','XL');
        $couleurs = array('bleu','vert','rouge','violet','orange');
        $articles = $this->articleRepository->findAll();
        for ($i=0; $i<50; $i++){
            $exemplaire = new Exemplaire();
            $exemplaire->setTaille($tailles[mt_rand(0,count($tailles)-1)])
                ->setCouleur($couleurs[mt_rand(0,count($couleurs)-1)])
                ->setType($articles[mt_rand(0,count($articles)-1)]);


            $manager->persist($exemplaire);
        }

        //ajout admin
        $user = new User();
        $user->setEmail('admin@172.26.82.23')
        ->setNom('admin')
        ->setPrenom('admin')
        ->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                securedpassword
            )
        )
        ->setRoles(['admin'])
        ->setSexe('H')
        ->setAdresse('IUT Nantes')
        ->setTel(6666666666);

        $manager->persist($user);


        $manager->flush();
    }
}
