<?php

namespace App\Repository;

use App\Entity\LignesCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LignesCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method LignesCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method LignesCommande[]    findAll()
 * @method LignesCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LignesCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LignesCommande::class);
    }

    // /**
    //  * @return LignesCommande[] Returns an array of LignesCommande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LignesCommande
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
