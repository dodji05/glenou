<?php

namespace App\Repository;

use App\Entity\AdsCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdsCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdsCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdsCategorie[]    findAll()
 * @method AdsCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdsCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdsCategorie::class);
    }

    // /**
    //  * @return AdsCategorie[] Returns an array of AdsCategorie objects
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
    public function findOneBySomeField($value): ?AdsCategorie
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
