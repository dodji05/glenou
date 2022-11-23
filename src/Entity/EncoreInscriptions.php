<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EncoreInscriptionsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"inscription:read"}},
 *     denormalizationContext={"groups"={"inscription:write"}}
 * )
 * @ORM\Entity(repositoryClass=EncoreInscriptionsRepository::class)
 */
class EncoreInscriptions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("inscription:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"inscription:read", "inscription:write"})
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"inscription:read", "inscription:write"})
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"inscription:read", "inscription:write"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"inscription:read", "inscription:write"})
     */
    private $Commune;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"inscription:read", "inscription:write"})
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"inscription:read", "inscription:write"})
     */
    private $DateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"inscription:read", "inscription:write"})
     */
    private $ReseauxSociaux;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("inscription:read")
     */
    private $DateInscription;

    /**
     * EncoreInscriptions constructor.
     */
    public function __construct()
    {
        $this->DateInscription = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(?string $Prenom): self
    {
        $this->Prenom = $Prenom;

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

    public function getCommune(): ?string
    {
        return $this->Commune;
    }

    public function setCommune(?string $Commune): self
    {
        $this->Commune = $Commune;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->DateNaissance;
    }

    public function setDateNaissance(?string $DateNaissance): self
    {
        $this->DateNaissance = $DateNaissance;

        return $this;
    }

    public function getReseauxSociaux(): ?string
    {
        return $this->ReseauxSociaux;
    }

    public function setReseauxSociaux(?string $ReseauxSociaux): self
    {
        $this->ReseauxSociaux = $ReseauxSociaux;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->DateInscription;
    }

    public function setDateInscription(?\DateTimeInterface $DateInscription): self
    {
        $this->DateInscription = $DateInscription;

        return $this;
    }
}
