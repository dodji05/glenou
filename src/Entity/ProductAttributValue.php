<?php

namespace App\Entity;

use App\Repository\ProductAttributValueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductAttributValueRepository::class)
 */
class ProductAttributValue
{

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="AttributValues")
     */
    private $produit;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=AttributValue::class, inversedBy="attributValues")
     */
    private $attributValue;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagevariations;


    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getAttributValue(): ?AttributValue
    {
        return $this->attributValue;
    }

    public function setAttributValue(?AttributValue $attributValue): self
    {
        $this->attributValue = $attributValue;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImagevariations(): ?string
    {
        return $this->imagevariations;
    }

    public function setImagevariations(?string $imagevariations): self
    {
        $this->imagevariations = $imagevariations;

        return $this;
    }
}
