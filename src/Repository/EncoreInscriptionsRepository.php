<?php

namespace App\Repository;

use App\Entity\EncoreInscriptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EncoreInscriptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method EncoreInscriptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method EncoreInscriptions[]    findAll()
 * @method EncoreInscriptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EncoreInscriptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EncoreInscriptions::class);
    }

    // /**
    //  * @return EncoreInscriptions[] Returns an array of EncoreInscriptions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EncoreInscriptions
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
