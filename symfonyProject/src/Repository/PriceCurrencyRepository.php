<?php

namespace App\Repository;

use App\Entity\PriceCurrency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PriceCurrency|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceCurrency|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceCurrency[]    findAll()
 * @method PriceCurrency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceCurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceCurrency::class);
    }

    // /**
    //  * @return PriceCurrency[] Returns an array of PriceCurrency objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PriceCurrency
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
