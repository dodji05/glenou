<?php

namespace App\Entity;

use App\Repository\VisiteursRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisiteursRepository::class)
 */
class Visiteurs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $AdresseIp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $PremiereConnection;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $derniereConnexion;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbVisite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseIp(): ?string
    {
        return $this->AdresseIp;
    }

    public function setAdresseIp(string $AdresseIp): self
    {
        $this->AdresseIp = $AdresseIp;

        return $this;
    }

    public function getPremiereConnection(): ?\DateTimeInterface
    {
        return $this->PremiereConnection;
    }

    public function setPremiereConnection(?\DateTimeInterface $PremiereConnection): self
    {
        $this->PremiereConnection = $PremiereConnection;

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

    public function getNbVisite(): ?int
    {
        return $this->nbVisite;
    }

    public function setNbVisite(?int $nbVisite): self
    {
        $this->nbVisite = $nbVisite;

        return $this;
    }
}
