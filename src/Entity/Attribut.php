<?php

namespace App\Entity;

use App\Repository\AttributRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributRepository::class)
 */
class Attribut
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
    private $Libelle;

    /**
     * @ORM\OneToMany(targetEntity=AttributValue::class, mappedBy="attribut")
     */
    private $valeur;

    public function __construct()
    {
        $this->valeur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(?string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    /**
     * @return Collection|AttributValue[]
     */
    public function getValeur(): Collection
    {
        return $this->valeur;
    }

    public function addValeur(AttributValue $valeur): self
    {
        if (!$this->valeur->contains($valeur)) {
            $this->valeur[] = $valeur;
            $valeur->setAttribut($this);
        }

        return $this;
    }

    public function removeValeur(AttributValue $valeur): self
    {
        if ($this->valeur->contains($valeur)) {
            $this->valeur->removeElement($valeur);
            // set the owning side to null (unless already changed)
            if ($valeur->getAttribut() === $this) {
                $valeur->setAttribut(null);
            }
        }

        return $this;
    }
}
