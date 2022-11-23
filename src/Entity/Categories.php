<?php



namespace App\Entity;



use ApiPlatform\Core\Annotation\ApiResource;

use App\Repository\CategoriesRepository;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Core\Annotation\ApiSubresource;

use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Serializer\Annotation\Groups;



/**

 * @ORM\Entity(repositoryClass=CategoriesRepository::class)

 * @ApiResource(

 *

 *      normalizationContext={"groups"={"categorie:read"}},

 *     denormalizationContext={"groups"={"categorie:write"}},

 *     attributes={"order"={"produits.id"="DESC"},"pagination_client_items_per_page"=true},
 *
 *


 * )

 */

class Categories

{

    /**

     * @ORM\Id()

     * @ORM\GeneratedValue()

     * @ORM\Column(type="integer")

     * @Groups({"categorie:read"})

     */

    private $id;



    /**

     * @ORM\Column(type="string", length=255, nullable=true)

     * @Groups({"categorie:read"})

     */

    private $libelle;



    /**

     * @Gedmo\Slug(fields={"libelle"})

     * @ORM\Column(type="string", length=255, nullable=true)

     */

    private $slug;



    /**

     * @ORM\Column(type="text", nullable=true)

     */

    private $Description;



    /**

     * @Gedmo\Timestampable(on="create")

     * @ORM\Column(type="datetime", nullable=true)

     */

    private $Created_at;



    /**

     * @Gedmo\Timestampable(on="update")

     * @ORM\Column(type="datetime", nullable=true)

     */

    private $Updated_at;



    /**

     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="children")

     */

    private $parent;



    /**

     * @ORM\OneToMany(targetEntity=Categories::class, mappedBy="parent")

     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")

     */

    private $children;



    /**

     * @ORM\ManyToMany(targetEntity=Produit::class, mappedBy="categorie")

     * @Groups({"categorie:read"})

     *  @ApiSubresource()
     */

    private $produits;



    /**

     * @ORM\Column(type="string", length=255, nullable=true)

     *  @Groups({"categorie:read"})

     */

    private $images;



    /**

     * @ORM\Column(type="integer", nullable=true)

     *  @Groups({"categorie:read"})

     */

    private $features;



    public function __construct()

    {

        $this->children = new ArrayCollection();

        $this->produits = new ArrayCollection();



    }



    public function getId(): ?int

    {

        return $this->id;

    }



    public function getLibelle(): ?string

    {

        return $this->libelle;

    }



    public function setLibelle(?string $libelle): self

    {

        $this->libelle = $libelle;



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



    public function getCreatedAt(): ?\DateTimeInterface

    {

        return $this->Created_at;

    }



    public function setCreatedAt(?\DateTimeInterface $Created_at): self

    {

        $this->Created_at = $Created_at;



        return $this;

    }



    public function getUpdatedAt(): ?\DateTimeInterface

    {

        return $this->Updated_at;

    }



    public function setUpdatedAt(?\DateTimeInterface $Updated_at): self

    {

        $this->Updated_at = $Updated_at;



        return $this;

    }



    public function getParent(): ?self

    {

        return $this->parent;

    }



    public function setParent(?self $parent): self

    {

        $this->parent = $parent;



        return $this;

    }



    /**

     * @return Collection|self[]

     */

    public function getChildren(): Collection

    {

        return $this->children;

    }



    public function addChild(self $child): self

    {

        if (!$this->children->contains($child)) {

            $this->children[] = $child;

            $child->setParent($this);

        }



        return $this;

    }



    public function removeChild(self $child): self

    {

        if ($this->children->contains($child)) {

            $this->children->removeElement($child);

            // set the owning side to null (unless already changed)

            if ($child->getParent() === $this) {

                $child->setParent(null);

            }

        }



        return $this;

    }



    /**

     * @return Collection|Produit[]

     */

    public function getProduits(): Collection

    {

        return $this->produits;

    }



    public function addProduit(Produit $produit): self

    {

        if (!$this->produits->contains($produit)) {

            $this->produits[] = $produit;

            $produit->addCategorie($this);

        }



        return $this;

    }



    public function removeProduit(Produit $produit): self

    {

        if ($this->produits->contains($produit)) {

            $this->produits->removeElement($produit);

            $produit->removeCategorie($this);

        }



        return $this;

    }





    public function getSlug(): ?string

    {

        return $this->slug;



    }



    public function __toString()

    {

        // TODO: Implement __toString() method.

        return $this->libelle;

    }







//    /**

//     * @param mixed $slug

//     */

//    public function setSlug($slug): void

//    {

//        $this->slug = $slug;

//    }



public function getImages(): ?string

{

    return $this->images;

}



public function setImages(?string $images): self

{

    $this->images = $images;



    return $this;

}



public function getFeatures(): ?int

{

    return $this->features;

}



public function setFeatures(?int $features): self

{

    $this->features = $features;



    return $this;

}





}

