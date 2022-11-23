<?php

namespace App\Repository;

use App\Entity\AdsImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdsImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdsImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdsImages[]    findAll()
 * @method AdsImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdsImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdsImages::class);
    }

    // /**
    //  * @return AdsImages[] Returns an array of AdsImages objects
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
    public function findOneBySomeField($value): ?AdsImages
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
