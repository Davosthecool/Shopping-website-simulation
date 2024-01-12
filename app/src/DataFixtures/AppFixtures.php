<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{

    private Generator $faker;
    public function __construct(){
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        $sexes=['M','F','N'];
        for ($i=0; $i<10; $i++){
            $product = new Article();
            $product->setNom($this->faker->words(4,true))
                ->setPrix(mt_rand(100,10000) / 100)
                ->setTailles(['XS','S','M','L','XL'])
                ->setCouleurs(['vert','rouge','bleu','violet','rose','orange','marron'])
                ->setTags([''])
                ->setSexe($sexes[mt_rand(0,count($sexes)-1)])
                ->setCategorie(null)
                ->setMarque(null)
                ->setStock(10)
                ->setImage('image 5.png');


            $manager->persist($product);
        }

        $manager->flush();
    }
}
