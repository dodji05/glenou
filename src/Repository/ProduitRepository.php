<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function ProduitsParCategorie($cat, $limit = null){
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.categorie','c')
            ->where('c.id= :val')
            ->orderBy('p.DatePublication', 'DESC')
            ->setParameter('val',$cat);
        if ($limit !== null){
            $qb->setMaxResults($limit);
        }
        return
            $qb->getQuery()
            ->getResult();

    }

    public function RechercheUnProduit ($q){
       return $qb = $this->createQueryBuilder('p')
            ->where('p.Nom LIKE :val')
           ->setParameter('val', '%' . $q . '%')
           ->getQuery()
           ->getResult();
    }

    public function SearchProduit ($search=null,$cat=null )
    {

       $query = $this
           ->createQueryBuilder('p')
           ->select('p','c')
           ->join('p.categorie','c');
       if(!empty($search)){
            $query = $query
                ->andWhere('p.Nom LIKE :q')
                ->setParameter('q',"%{$search}%");
       }
//        if(!empty($search->cat)){
//
//        }

        return $query->getQuery()->getResult();
    }
}
