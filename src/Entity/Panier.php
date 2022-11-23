<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(normalizationContext={"groups"={"panier"}}
 *     ,
 *   denormalizationContext = {"groups" = {"ajout"}})
 *  @ApiFilter(SearchFilter::class, properties={"client": "exact"})
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id()
     *
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /** @var string
     *
     * @Groups({"panier","ajout"})
     *

     * @ORM\Column(name="client_id", type="string", length=255, nullable=true)
     *
     */
    private $client;

    /**
     *@Groups({"panier","ajout"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix;

    /**
     * @Groups({"panier","ajout"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantite;

    /**
      *
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="paniers")
     *  @Groups({"panier","ajout"})
     */
    private $produit;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getClient(): ?String
    {
        return $this->client;
    }

    public function setClient(?String $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
