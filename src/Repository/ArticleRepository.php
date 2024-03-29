<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

   /**
    * @return Article[] Returns an array of Article objects
    */
   public function findByNomContains(array $listepossibilites): array
   {
        $queryBuilder = $this->createQueryBuilder('a');
        $orX = $queryBuilder->expr()->orX();

        foreach ($listepossibilites as $index => $nom) {
            $parameterName = 'nom' . $index;
            $orX->add($queryBuilder->expr()->like('a.nom', ':' . $parameterName));
            $queryBuilder->setParameter($parameterName, '%' . $nom . '%');
        }

        $queryBuilder->andWhere($orX)->orderBy('a.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
   }


     /**
    * @return Article[] Returns an array of Article objects
    */
   public function findByTags($values): array
   {
       return $this->createQueryBuilder('a')
           ->andWhere('a.tags LIKE :values')
           ->setParameter('values', '%' . implode('%', $values) . '%')
           ->orderBy('a.nom', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

   //    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
