<?php

namespace App\Repository;

use App\Entity\AdsType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdsType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdsType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdsType[]    findAll()
 * @method AdsType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdsTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdsType::class);
    }

    // /**
    //  * @return AdsType[] Returns an array of AdsType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdsType
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
