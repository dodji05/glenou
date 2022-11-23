<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LieuxDeLivraison;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateReservation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateDeLivraison;

    /**
     * @ORM\OneToMany(targetEntity=ReservationItems::class, mappedBy="reservations")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getLieuxDeLivraison(): ?string
    {
        return $this->LieuxDeLivraison;
    }

    public function setLieuxDeLivraison(?string $LieuxDeLivraison): self
    {
        $this->LieuxDeLivraison = $LieuxDeLivraison;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->DateReservation;
    }

    public function setDateReservation(?\DateTimeInterface $DateReservation): self
    {
        $this->DateReservation = $DateReservation;

        return $this;
    }

    public function getDateDeLivraison(): ?\DateTimeInterface
    {
        return $this->DateDeLivraison;
    }

    public function setDateDeLivraison(?\DateTimeInterface $DateDeLivraison): self
    {
        $this->DateDeLivraison = $DateDeLivraison;

        return $this;
    }

    /**
     * @return Collection|ReservationItems[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ReservationItems $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setReservations($this);
        }

        return $this;
    }

    public function removeItem(ReservationItems $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getReservations() === $this) {
                $item->setReservations(null);
            }
        }

        return $this;
    }
}
