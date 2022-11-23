<?php

namespace App\Repository;

use App\Entity\ReservationItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReservationItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationItems[]    findAll()
 * @method ReservationItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationItems::class);
    }

    // /**
    //  * @return ReservationsItems[] Returns an array of ReservationsItems objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReservationsItems
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
