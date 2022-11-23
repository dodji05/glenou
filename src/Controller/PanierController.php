<?php


namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Services\Panier\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

 /**
     * @Route("/mon-panier", name="app_cart")
     */
    public function index (PanierService $panier,ProduitRepository $produitRepository){
        $panierdata = [];
        foreach ($panier->get() as $id => $quantity) {
            $panierdata[] = [
                'produit' => $produitRepository->find($id),
                'quantite' => $quantity

            ];

        }
        $total =0;
        foreach($panierdata as $item){
    $subtotal = (int) $item['produit']->getPrix()  * $item['quantite'];
    $total +=$subtotal;

        }

        return $this->render('commande/panier.html.twig', [
            'elements' => $panierdata,
            'total'=>$total,
            //'form' => $form->createView(),
          
        ]);

    }

    /**
     * @Route("/mon-panier/add/{id}", name="app_cart_add")
     */
    public function add (PanierService $panier,$id){

        $panier->ajout($id);
        return $this->redirectToRoute('app_cart'); 
    }

    /**
     * @Route("/mon-panier/remove", name="app_cart_remove")
     */
    public function remove (PanierService $panier){
        $panier->vider();
    }

    
    /**
     * @Route("/mon-panier/delete/{id}", name="app_cart_delete")
     */
    public function delete (PanierService $panier, $id){
        $panier->supprimer($id);
        return $this->redirectToRoute('app_cart'); 
    }

    /**
     * @Route("/mon-panier/retirer/{id}", name="app_cart_retirer")
     */
    public function dimunier (PanierService $panier, $id){
        $panier->dimunier($id);
        return $this->redirectToRoute('app_cart');
    }

}