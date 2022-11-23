<?php

namespace App\Entity;

use App\Repository\AttributValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributValueRepository::class)
 */
class AttributValue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Attribut::class, inversedBy="valeur",cascade={"persist"})
     */
    private $attribut;

    /**
     * @ORM\ManyToMany(targetEntity=Produit::class, mappedBy="attribute_value")
     */
    private $produits;

    /**
     * @ORM\OneToMany(targetEntity=ProductAttributValue::class, mappedBy="attributValue")
     */
    private $attributValues;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->attributValues = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getAttribut(): ?Attribut
    {
        return $this->attribut;
    }

    public function setAttribut(?Attribut $attribut): self
    {
        $this->attribut = $attribut;

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
            $produit->addAttributeValue($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
            $produit->removeAttributeValue($this);
        }

        return $this;
    }

    /**
     * @return Collection|ProductAttributValue[]
     */
    public function getAttributValues(): Collection
    {
        return $this->attributValues;
    }

    public function addAttributValue(ProductAttributValue $attributValue): self
    {
        if (!$this->attributValues->contains($attributValue)) {
            $this->attributValues[] = $attributValue;
            $attributValue->setAttributValue($this);
        }

        return $this;
    }

    public function removeAttributValue(ProductAttributValue $attributValue): self
    {
        if ($this->attributValues->contains($attributValue)) {
            $this->attributValues->removeElement($attributValue);
            // set the owning side to null (unless already changed)
            if ($attributValue->getAttributValue() === $this) {
                $attributValue->setAttributValue(null);
            }
        }

        return $this;
    }



}
