<?php

namespace App\Entity;

use App\Repository\ProduitstatsvisiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitstatsvisiteRepository::class)
 */
class Produitstatsvisite
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="statsproduit")
     */
    private $produit;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=Visiteurs::class, inversedBy="stats")
     */

    private $visiteur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $derniereConnexion;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbVisite;



    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
    public function getVisiteur(): ?Visiteurs
    {
        return $this->visiteur;
    }

    public function setVisiteur(?Visiteurs $visiteur): self
    {
        $this->visiteur = $visiteur;

        return $this;
    }
    public function getNbVisite(): ?int
    {
        return $this->nbVisite;
    }

    public function setNbVisite(?int $nbVisite): self
    {
        $this->nbVisite = $nbVisite;

        return $this;
    }

    public function getDerniereConnexion(): ?\DateTimeInterface
    {
        return $this->derniereConnexion;
    }

    public function setDerniereConnexion(?\DateTimeInterface $derniereConnexion): self
    {
        $this->derniereConnexion = $derniereConnexion;

        return $this;
    }


}
