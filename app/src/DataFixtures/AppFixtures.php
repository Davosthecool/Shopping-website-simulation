<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Exemplaire;
use App\Repository\ArticleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{

    private Generator $faker;
    private ArticleRepository $articleRepository;
    public function __construct(ArticleRepository $articleRepository){
        $this->faker = Factory::create('fr_FR');
        $this->articleRepository = $articleRepository;
    }
    public function load(ObjectManager $manager): void
    {
        // Remplissage de la BD avec des Articles aléatoires
        $sexes=['M','F','N'];
        for ($i=0; $i<10; $i++){
            $product = new Article();
            $product->setNom($this->faker->words(4,true))
                ->setPrix(mt_rand(100,10000) / 100)
                ->setTailles([])
                ->setCouleurs([])
                ->setTags([])
                ->setSexe($sexes[mt_rand(0,count($sexes)-1)])
                ->setCategorie(null)
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
        $manager->flush();
    }
}
