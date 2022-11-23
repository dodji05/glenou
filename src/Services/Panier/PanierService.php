<?php


namespace App\Services\Panier;


use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class PanierService
{
    private $session;
    private $produitRepository;

    public function __construct(SessionInterface $session, ProduitRepository $produitsRepository)
    {
        $this->session = $session;
        $this->produitRepository = $produitsRepository;
    }

    public function ajout($id)
    {
        $panier = $this->session->get('panier', []);
        //dd($id);
        if (empty($panier[$id])) {
            $panier[$id] = 1;
        } else {
            $panier[$id]++;
        }

        return $this->session->set('panier', $panier);


    }

    public function get()
    {
        return $this->session->get('panier');
    }

    public function vider()
    {
        return $this->session->remove('panier');
    }

    public function supprimer($id)
    {
        $panier = $this->session->get('panier', []);
        unset($panier[$id]);
        return $this->session->set('panier', $panier);

    }

    public function dimunier($id)
    {
        $panier = $this->session->get('panier', []);
        //dd($id);
        if ($panier[$id] > 1) {
            $panier[$id]--;
        } else {
            unset($panier[$id]);
        }
        return $this->session->set('panier', $panier);
    }

    public function getFull()
    {
        $panierdata = [];
        foreach ($this->get() as $id => $quantity) {
            $panierdata[] = [
                'produit' => $this->produitRepository->find($id),
                'quantite' => $quantity

            ];

        }
        $total = 0;
        foreach ($panierdata as $item) {
            $subtotal = (int)$item['produit']->getPrix() * $item['quantite'];
            $total += $subtotal;

        }
        return $panierdata;
    }
}