<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use App\Repository\BonsPlansRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=BonsPlansRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"bonsplans:read"}}
 * )
 * @ApiFilter(DateFilter::class, properties={"DateFin"})
 */
class BonsPlans
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"bonsplans:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"bonsplans:read"})
     */
    private $PrixBonsPlans;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"bonsplans:read"})
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"bonsplans:read"})
     *
     */
    private $DateFin;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="bonsPlans")
     * @Groups({"bonsplans:read"})
     */
    private $Produit;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"bonsplans:read"})
     */
    private $EnStock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"bonsplans:read"})
     */
    private $vendu;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"bonsplans:read"})
     */
    private $quantite;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixBonsPlans(): ?float
    {
        return $this->PrixBonsPlans;
    }

    public function setPrixBonsPlans(float $PrixBonsPlans): self
    {
        $this->PrixBonsPlans = $PrixBonsPlans;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(?\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->Produit;
    }

    public function setProduit(?Produit $Produit): self
    {
        $this->Produit = $Produit;

        return $this;
    }

    public function getEnStock(): ?int
    {
        return $this->EnStock;
    }

    public function setEnStock(int $EnStock): self
    {
        $this->EnStock = $EnStock;

        return $this;
    }

    public function getVendu(): ?int
    {
        return $this->vendu;
    }

    public function setVendu(?int $vendu): self
    {
        $this->vendu = $vendu;

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
