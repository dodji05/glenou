<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LignesCommandeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass=LignesCommandeRepository::class)
 * @ApiResource
 */
class LignesCommande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"commande:read", "commande:write"})
     *
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="lignesCommandes")
     *@Groups({"commande:read", "commande:write"})
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Commandes::class, inversedBy="lignesCommandes")
     *
     *
     */
    private $commande;

    /**
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"commande:read", "commande:write"})
     */
    private $Prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"commande:read", "commande:write"})
     */
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCommande(): ?Commandes
    {
        return $this->commande;
    }

    public function setCommande(?Commandes $commande): self
    {
        $this->commande = $commande;

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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
