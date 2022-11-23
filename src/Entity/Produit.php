<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 * @Vich\Uploadable
 * @ApiResource(
 *      normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 *     attributes={"pagination_client_items_per_page"=true},
 *
 *      itemOperations={
 *     "get",
 *     "produit_par_categorie"={
 *                      "method"="GET",
 *                      "path" = "/categorie/{id}/produits",
 *                      "controller" = App\Controller\CategorieproduitAccueil::class,
 *     "normalization_context"={"groups"={"categorie:read"}},
 *
 *     }

 *     },
 *      subresourceOperations={
 *     "api_produits_par_categorie"={
 *     "method"="GET",
 *    "normalization_context"= {"groups"={"user:read"}}
 *     }
 *     }
 *     )
 *
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"panier","categorie:read"})
     * @Groups({"commande:read"})
     *
     */
    private $id;

    /**
     * @Groups({"panier"})
     * @ORM\Column(type="string", length=255)
     * @Groups({"commande:read", "commande:write","categorie:read","bonsplans:read"})
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Code;

    /**
     * @Gedmo\Slug(fields={"Nom"})
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private $Slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $DescriptionCourte;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"commande:read","categorie:read","bonsplans:read"})
     */
    private $Prix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsFeatured;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Udpated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DatePublication;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"panier"})
     * @Groups({"bonsplans:read"})
     *  @Groups({"commande:read","categorie:read"})
*/
    private $ImagePrincipale;

    /**
     * @Vich\UploadableField(mapping="produits", fileNameProperty="ImagePrincipale")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Status;

    /**
     *
     * * @Groups({"panier"})
     * @Groups({"bonsplans:read"})
     *  @Groups({"commande:read","categorie:read"})
     * */
    private $chemin;

    /**
     * @return mixed
     */
    public function getChemin()
    {
        return 'https://'.$_SERVER['SERVER_NAME'].'/uploads/images/produits/'.$this->getImagePrincipale();

       // return "https://store.jinukun.bj/uploads/images/produits/".$this->getImagePrincipale();
    }

    /**
     * @ORM\ManyToMany(targetEntity=AttributValue::class, inversedBy="produits")
     */
    private $attribute_value;

    /**
     * @ORM\OneToMany(targetEntity=ProduitImages::class, mappedBy="produit")
     */
    private $ImagesAutres;

    /**
     * @ORM\ManyToMany(targetEntity=Categories::class, inversedBy="produits")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=ProductAttributValue::class, mappedBy="produit")
     */
    private $AttributValues;

    /**
     * @ORM\OneToMany(targetEntity=Produitstatsvisite::class, mappedBy="produit")
     */
    private $statsproduit;

    /**
     * @ORM\OneToMany(targetEntity=LignesCommande::class, mappedBy="produit")
     * @MaxDepth(5)
     */
    private $lignesCommandes;

    /**
     * @ORM\OneToMany(targetEntity=ReservationItems::class, mappedBy="produit")
     */
    private $reservationItems;

    /**
     * @ORM\OneToMany(targetEntity=Panier::class, mappedBy="produit")
     */
    private $paniers;

    /**
     * @ORM\OneToMany(targetEntity=BonsPlans::class, mappedBy="Produit")
     */
    private $bonsPlans;



    public function __construct()
    {
        $this->attribute_value = new ArrayCollection();
        $this->ImagesAutres = new ArrayCollection();
        $this->categorie = new ArrayCollection();
        $this->IsFeatured = false;
        $this->Status = 'Publie';
        $this->DatePublication =new \DateTime();
        $this->AttributValues = new ArrayCollection();
        $this->lignesCommandes = new ArrayCollection();
        $this->statsproduit  = new ArrayCollection();
        $this->reservationItems = new ArrayCollection();
        $this->paniers = new ArrayCollection();
        $this->bonsPlans = new  ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(?string $Code): self
    {
        $this->Code = $Code;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->Slug;
    }

//    public function setSlug(?string $Slug): self
//    {
//        $this->Slug = $Slug;
//
//        return $this;
//    }

    public function getDescriptionCourte(): ?string
    {
        return $this->DescriptionCourte;
    }

    public function setDescriptionCourte(?string $DescriptionCourte): self
    {
        $this->DescriptionCourte = $DescriptionCourte;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(?float $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getIsFeatured(): ?bool
    {
        return $this->IsFeatured;
    }

    public function setIsFeatured(bool $IsFeatured): self
    {
        $this->IsFeatured = $IsFeatured;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUdpatedAt(): ?\DateTimeInterface
    {
        return $this->Udpated_at;
    }

    public function setUdpatedAt(?\DateTimeInterface $Udpated_at): self
    {
        $this->Udpated_at = $Udpated_at;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->DatePublication;
    }

    public function setDatePublication(?\DateTimeInterface $DatePublication): self
    {
        $this->DatePublication = $DatePublication;

        return $this;
    }

    public function getImagePrincipale(): ?string
    {
        return $this->ImagePrincipale;
    }

    public function setImagePrincipale(?string $ImagePrincipale): self
    {
        $this->ImagePrincipale = $ImagePrincipale;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(?string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    /**
     * @return Collection|AttributValue[]
     */
    public function getAttributeValue(): Collection
    {
        return $this->attribute_value;
    }

    public function addAttributeValue(AttributValue $attributeValue): self
    {
        if (!$this->attribute_value->contains($attributeValue)) {
            $this->attribute_value[] = $attributeValue;
        }

        return $this;
    }

    public function removeAttributeValue(AttributValue $attributeValue): self
    {
        if ($this->attribute_value->contains($attributeValue)) {
            $this->attribute_value->removeElement($attributeValue);
        }

        return $this;
    }

    /**
     * @return Collection|ProduitImages[]
     */
    public function getImagesAutres(): Collection
    {
        return $this->ImagesAutres;
    }

    public function addImagesAutre(ProduitImages $imagesAutre): self
    {
        if (!$this->ImagesAutres->contains($imagesAutre)) {
            $this->ImagesAutres[] = $imagesAutre;
            $imagesAutre->setProduit($this);
        }

        return $this;
    }

    public function removeImagesAutre(ProduitImages $imagesAutre): self
    {
        if ($this->ImagesAutres->contains($imagesAutre)) {
            $this->ImagesAutres->removeElement($imagesAutre);
            // set the owning side to null (unless already changed)
            if ($imagesAutre->getProduit() === $this) {
                $imagesAutre->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Categories[]
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categories $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie[] = $categorie;
        }

        return $this;
    }

    public function removeCategorie(Categories $categorie): self
    {
        if ($this->categorie->contains($categorie)) {
            $this->categorie->removeElement($categorie);
        }

        return $this;
    }
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

//        if ($image) {
//            $this->updated_at = new \DateTime('now');
//        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @return Collection|ProductAttributValue[]
     */
    public function getAttributValues(): Collection
    {
        return $this->AttributValues;
    }

    public function addAttributValue(ProductAttributValue $attributValue): self
    {
        if (!$this->AttributValues->contains($attributValue)) {
            $this->AttributValues[] = $attributValue;
            $attributValue->setProduit($this);
        }

        return $this;
    }

    public function removeAttributValue(ProductAttributValue $attributValue): self
    {
        if ($this->AttributValues->contains($attributValue)) {
            $this->AttributValues->removeElement($attributValue);
            // set the owning side to null (unless already changed)
            if ($attributValue->getProduit() === $this) {
                $attributValue->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LignesCommande[]
     */
    public function getLignesCommandes(): Collection
    {
        return $this->lignesCommandes;
    }

    public function addLignesCommande(LignesCommande $lignesCommande): self
    {
        if (!$this->lignesCommandes->contains($lignesCommande)) {
            $this->lignesCommandes[] = $lignesCommande;
            $lignesCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLignesCommande(LignesCommande $lignesCommande): self
    {
        if ($this->lignesCommandes->contains($lignesCommande)) {
            $this->lignesCommandes->removeElement($lignesCommande);
            // set the owning side to null (unless already changed)
            if ($lignesCommande->getProduit() === $this) {
                $lignesCommande->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Produitstatsvisite[]
     */
    public function getStatsproduit(): Collection
    {
        return $this->statsproduit;
    }

    public function addStatsproduit(Produitstatsvisite $Statsproduit): self
    {
        if (!$this->statsproduit->contains($Statsproduit)) {
            $this->statsproduit[] = $Statsproduit;
            $Statsproduit->setProduit($this);
        }

        return $this;
    }

    public function removeStatsproduit(Produitstatsvisite $Statsproduit): self
    {
        if ($this->statsproduit->contains($Statsproduit)) {
            $this->statsproduit->removeElement($Statsproduit);
            // set the owning side to null (unless already changed)
            if ($Statsproduit->getProduit() === $this) {
                $Statsproduit->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReservationItems[]
     */
    public function getReservationItems(): Collection
    {
        return $this->reservationItems;
    }

    public function addReservationItem(ReservationItems $reservationItem): self
    {
        if (!$this->reservationItems->contains($reservationItem)) {
            $this->reservationItems[] = $reservationItem;
            $reservationItem->setProduit($this);
        }

        return $this;
    }

    public function removeReservationItem(ReservationItems $reservationItem): self
    {
        if ($this->reservationItems->contains($reservationItem)) {
            $this->reservationItems->removeElement($reservationItem);
            // set the owning side to null (unless already changed)
            if ($reservationItem->getProduit() === $this) {
                $reservationItem->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Panier[]
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers[] = $panier;
            $panier->setProduit($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->contains($panier)) {
            $this->paniers->removeElement($panier);
            // set the owning side to null (unless already changed)
            if ($panier->getProduit() === $this) {
                $panier->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BonsPlans[]
     */
    public function getBonsPlans(): Collection
    {
        return $this->bonsPlans;
    }
}
