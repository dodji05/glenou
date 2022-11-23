<?php

namespace App\Repository;

use App\Entity\Visiteurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Visiteurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visiteurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visiteurs[]    findAll()
 * @method Visiteurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visiteurs::class);
    }

    public function visiteurTotal ()
    {
        return $this->createQueryBuilder('v')
            ->select('SUM(v.nbVisite)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // /**
    //  * @return Visiteurs[] Returns an array of Visiteurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Visiteurs
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
