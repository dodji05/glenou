<?php

namespace App\Entity;

use App\Repository\QuartierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuartierRepository::class)
 */
class Quartier
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
    private $nomQuatier;

    /**
     * @ORM\Column(type="float",  nullable=true)
     */
    private $FraisLivraison;


    /**
     * @ORM\ManyToOne(targetEntity=Villes::class, inversedBy="quartiers")
     */
    private $ville;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomQuatier(): ?string
    {
        return $this->nomQuatier;
    }

    public function setNomQuatier(?string $nomQuatier): self
    {
        $this->nomQuatier = $nomQuatier;

        return $this;
    }

    public function getFraisLivraison(): ?float
    {
        return $this->FraisLivraison;
    }

    public function setFraisLivraison(?float $FraisLivraison): self
    {
        $this->FraisLivraison = $FraisLivraison;

        return $this;
    }



    public function getVille(): ?Villes
    {
        return $this->ville;
    }

    public function setVille(?Villes $ville): self
    {
        $this->ville = $ville;

        return $this;
    }
}
