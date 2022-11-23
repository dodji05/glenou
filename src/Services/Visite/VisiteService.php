<?php


namespace App\Services\Visite;


use App\Entity\Produit;

use App\Entity\Produitstatsvisite;
use App\Entity\Visiteurs;
use App\Repository\ProduitstatsvisiteRepository;
use App\Repository\VisiteursRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class VisiteService
{
    protected $visiteursRepository;
    protected $produitstatsvisiteRepository;
    private $request;
    private $em;
    private $ip;

    public function __construct(VisiteursRepository $visiteursRepository,/* Request $request,*/ EntityManagerInterface $em,ProduitstatsvisiteRepository $produitstatsvisite)
    {
        $this->visiteursRepository = $visiteursRepository;
       // $this->request = $request;
        $this->em = $em;
        $this->produitstatsvisiteRepository = $produitstatsvisite;
        $this->ip = $_SERVER['REMOTE_ADDR'];//$this->request->getClientIp();
    }

    public function visitegenerale()
    {
        $adresseip = $_SERVER['REMOTE_ADDR'];//$this->request->getClientIp();
        $stats_visite = ($this->visiteursRepository->findOneBy(['AdresseIp' => $adresseip]));

        if ($stats_visite) {
            //Le visiteur est deja venu une fois sur la page
            $nbvisite = $stats_visite->getNbVisite();

            $lastvisite = date_format($stats_visite->getDerniereConnexion(), 'Y-m-d H:i:s');
            $current = date_format(new \DateTime(), 'Y-m-d H:i:s');
            $difference_date = date_diff(date_create($lastvisite) ,date_create($current))->h;

           //dd($difference_date);
           if ($difference_date > 13)
           {
             //  dd('on sauvergade');
               $stats_visite->setDerniereConnexion(new \DateTime());
               $stats_visite->setNbVisite($nbvisite + 1);
               // $stats_visit
               $this->em->persist($stats_visite);
           }
         

        } else {
            //Premier visite
            $stats =  $this->nouveauVisiteur();


        }
        $this->em->flush();
    }

    public function produitvisite(Produit $produit){

        $visiteur = ($this->visiteursRepository->findOneBy(['AdresseIp' => $this->ip]));


        if($visiteur){
            // deja venu au moins une fois
            $stats_produit = ($this->produitstatsvisiteRepository->findOneBy(['visiteur' => $visiteur,'produit'=>$produit]));
            if ($stats_produit){
                // Deja visite le produit

                $nbvisite = $stats_produit->getNbVisite();

                $lastvisite = date_format($stats_produit->getDerniereConnexion(), 'Y-m-d H:i:s');
                $current = date_format(new \DateTime(), 'Y-m-d H:i:s');
                $difference_date = date_diff(date_create($lastvisite) ,date_create($current))->h;

                //dd($difference_date);
                if ($difference_date > 11)
                {
                    //  dd('on sauvergade');
                    $stats_produit->setDerniereConnexion(new \DateTime());
                    $stats_produit->setNbVisite($nbvisite + 1);
                    // $stats_visit
                    $this->em->persist($stats_produit);
                }
            }
            else{
                // il n'a jamais visite le produit
                $produitStats =  new  Produitstatsvisite();
                $produitStats->setProduit($produit);
                $produitStats->setVisiteur($visiteur);
                $produitStats->setDerniereConnexion(new \DateTime());
                $produitStats->setNbVisite(1);

                $this->em->persist($produitStats);

            }

        }
        else {
            // Il vient pour la premier fois sur sur le site

            $stats =  $this->nouveauVisiteur();
            $produitStats =  new  Produitstatsvisite();
            $produitStats->setProduit($produit);
            $produitStats->setVisiteur($stats);
            $produitStats->setDerniereConnexion(new \DateTime());
            $produitStats->setNbVisite(1);
            $this->em->persist($produitStats);


        }
        $this->em->flush();

    }

    private function nouveauVisiteur ()
    {
        $stats = new Visiteurs();
        $stats->setPremiereConnection(new \DateTime());
        $stats->setDerniereConnexion(new \DateTime());
        $stats->setNbVisite(1);
        $stats->setAdresseIp($this->ip);
        $this->em->persist($stats);

        return $stats;
    }

    public function nbreVisiteParproduit (Produit $produit){
        return $this->produitstatsvisiteRepository->nbVuesParProduit($produit);
    }
}