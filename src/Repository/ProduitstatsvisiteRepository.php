<?php


namespace App\Repository;


use App\Entity\Produit;
use App\Entity\Produitstatsvisite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Produitstatsvisite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produitstatsvisite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produitstatsvisite[]    findAll()
 * @method Produitstatsvisite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitstatsvisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produitstatsvisite::class);
    }

    public function nbVuesParProduit(Produit $produit){

        return $this->createQueryBuilder('p')
            ->select('SUM(p.nbVisite)')
            ->leftJoin('p.produit', 'pr')
            ->where('p.produit = :produit')
            ->setParameter('produit', $produit)
            ->getQuery()
            ->getSingleScalarResult();

        }

    public function ProduitLePlusVu(){

        return $this->createQueryBuilder('p')
            ->select('SUM(p.nbVisite) as total')
            ->leftJoin('p.produit', 'pr')
            ->groupBy('pr.id')
            ->orderBy('total','desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

    }
}