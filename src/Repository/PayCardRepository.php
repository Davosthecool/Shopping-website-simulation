<?php

namespace App\Repository;

use App\Entity\PayCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PayCard>
 *
 * @method PayCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method PayCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method PayCard[]    findAll()
 * @method PayCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PayCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PayCard::class);
    }

//    /**
//     * @return PayCard[] Returns an array of PayCard objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PayCard
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
