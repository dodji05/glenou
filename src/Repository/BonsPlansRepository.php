<?php

namespace App\Repository;

use App\Entity\BonsPlans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BonsPlans|null find($id, $lockMode = null, $lockVersion = null)
 * @method BonsPlans|null findOneBy(array $criteria, array $orderBy = null)
 * @method BonsPlans[]    findAll()
 * @method BonsPlans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BonsPlansRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BonsPlans::class);
    }

    // /**
    //  * @return BonsPlans[] Returns an array of BonsPlans objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BonsPlans
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function BonsPlansEencors() {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.Produit', 'p')
            ->where('CURRENT_DATE() BETWEEN b.DateDebut AND b.DateFin')

         //   ->orderBy('b.dateDebut', 'ASC')

            ->getQuery()
            ->getResult()
            ;
    }
}
