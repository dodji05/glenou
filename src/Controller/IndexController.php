<?php


namespace App\Controller;


use App\Entity\Categories;
use App\Entity\Produit;

use App\Repository\CategoriesRepository;
use App\Repository\ProduitRepository;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Services\Visite\VisiteService;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_accueil")
     */
    public function index(CategoriesRepository $categorieRepository, ProduitRepository $produitsRepository, UserRepository $userRepository, VisiteService $visite)
    {
        $produits = $produitsRepository->findBy(
            [],
            ['id' => 'DESC'],
            10);

        $producteurs = $userRepository->findBy(['id'=>1234567890]);
        $visite->visitegenerale();
        return $this->render('front/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'produits' => $produits,
            'meilleursVentes' => $produits,
            'produitsPopulaires' => $produits,
            'producteurs' => $producteurs
        ]);
    }

    /**
     * @Route("/produits/{Slug}", name="app_fiche_produit")
     */
    public function ficheProduit(Produit $produit, ProduitRepository $produitsRepository, VisiteService $visite)
    {
        $visite->produitvisite($produit);
        $produits = $produitsRepository->findBy(['id' => $produit->getId()]);
        return $this->render('front/fiche_produit.html.twig', [
            'produit' => $produit,
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/nos-produits", name="app_boutique")
     */
    public function boutique(Request $request, ProduitRepository $produitsRepository, PaginatorInterface $paginator)
    {

        $produits = $produitsRepository->findBy(
            [],
            ['id' => 'DESC']);
        $produits = $paginator->paginate($produits = $produitsRepository->findBy(
            [],
            ['id' => 'DESC'])

            , // Requête contenant les données à paginer (ici nos articles)

            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page

            45 // Nombre de résultats par page

        );
        return $this->render('front/notre-boutique.html.twig', [
            'type' => null,
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/categorie/{slug}", name="app_categorie_boutique")
     */
    public function categorieProduits(Request $request, Categories $categorieProduits, PaginatorInterface $paginator)
    {

        $produits = $paginator->paginate($categorieProduits->getProduits()

            , // Requête contenant les données à paginer (ici nos articles)

            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page

            15 // Nombre de résultats par page

        );

        return $this->render('front/notre-boutique.html.twig', [

            'produits' => $produits,
            'type' => 'categorie',
            'categorie' => $categorieProduits->getLibelle()
        ]);
    }

    /**
     * @Route("/cgu", name="app_cgu")
     */
    public function cgu()
    {
        return $this->render('front/cgu.html.twig');
    }

    /**
     * @Route("/politique-de-confidentialite", name="app_politique")
     */
    public function politique()
    {
        return $this->render('front/cgu.html.twig');
    }

    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact()
    {
        return $this->render('front/contact.html.twig');
    }

    /**
     * @Route("/glenou", name="app_eyobu")
     */
    public function eyobu()
    {
        return $this->render('front/abouts_us.html.twig');
    }


}