<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass=CommandesRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"commande:read"}},
 *     denormalizationContext={"groups"={"commande:write"}},
 *     itemOperations={
 *     "get"={},
 *     "commandes_valide" = {
 *          "method"="GET",
 *          "path"="/Commandes/{id}/valide",
 *          "controller"=App\Controller\Api\CommandeValide::class
 *     },
 *     "put"={},
 *     "delete"={},
 *     "patch"={}
 *     }
 * )
 */
class Commandes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"commande:read"})
     */
    private $id;

    /**
     * @Groups({"commande:read"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateCommande;

    /** @Groups({"commande:read","commande:write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Client;

    /** @Groups({"commande:read"})
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $Etat;

    /**
     *  @Groups({"commande:read", "commande:write"})
     * @ORM\OneToMany(targetEntity=LignesCommande::class, mappedBy="commande")
     */

    private $lignesCommandes;

    /** @Groups({"commande:read","commande:write"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Commande")
     */
    private $user;

    /** @Groups({"commande:read"})
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $ReferencePaiement;

    /** @Groups({"commande:read","commande:write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $AdresseLivraison;

    public function __construct()
    {
        $this->lignesCommandes = new ArrayCollection();
        $this->DateCommande = new  \DateTime();
        $this->Etat = "Encoours";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->DateCommande;
    }

    public function setDateCommande(?\DateTimeInterface $DateCommande): self
    {
        $this->DateCommande = $DateCommande;

        return $this;
    }

    public function getClient(): ?int
    {
        return $this->Client;
    }

    public function setClient(?int $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->Etat;
    }

    public function setEtat(?string $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }

    /**
     * @return Collection|LignesCommande[]
     */
    public function getLignesCommandes(): Collection
    {
        return $this->lignesCommandes;
    }

    public function addLignesCommande(LignesCommande $lignesCommande): self
    {
        if (!$this->lignesCommandes->contains($lignesCommande)) {
            $this->lignesCommandes[] = $lignesCommande;
            $lignesCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLignesCommande(LignesCommande $lignesCommande): self
    {
        if ($this->lignesCommandes->contains($lignesCommande)) {
            $this->lignesCommandes->removeElement($lignesCommande);
            // set the owning side to null (unless already changed)
            if ($lignesCommande->getCommande() === $this) {
                $lignesCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferencePaiement()
    {
        return $this->ReferencePaiement;
    }

    /**
     * @param mixed $ReferencePaiement
     */
    public function setReferencePaiement($ReferencePaiement): void
    {
        $this->ReferencePaiement = $ReferencePaiement;
    }

    /**
     * @return mixed
     */
    public function getAdresseLivraison()
    {
        return $this->AdresseLivraison;
    }

    /**
     * @param mixed $AdresseLivraison
     */
    public function setAdresseLivraison($AdresseLivraison): void
    {
        $this->AdresseLivraison = $AdresseLivraison;
    }

}
