<?php


namespace App\Services\Categorie;




use App\Repository\CategoriesRepository;
use App\Repository\ProduitRepository;


class LesCategories

{
    protected  $categoriesRepository;
    protected  $produitRepository;

    /**
     * LesCategories constructor.
     * @param CategoriesRepository $categoriesRepository
     * @param ProduitRepository $produitRepository
     */
    public function __construct(CategoriesRepository $categoriesRepository,ProduitRepository $produitRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
        $this->produitRepository = $produitRepository;
    }

    public function getCategorie()
    {
        return $this->categoriesRepository->findAll();
    }

    public function getTiwaProduits()
    {
        return $marque_tiwa = $this->produitRepository->findBy(['id'=>[141,140,97,83,90,3,92,50,141,140,]]);

    }

    public function produitMenu()
    {
        $produitMenu[] =  $this->categoriesRepository->findOneBy(['id'=>8],['id'=>'desc'],5);
        $produitMenu[] =  $this->categoriesRepository->findOneBy(['id'=>14],['id'=>'desc'],5);
        return $produitMenu;
    }

}