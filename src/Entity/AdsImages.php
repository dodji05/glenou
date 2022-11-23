<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdsImagesRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdsImagesRepository::class)
 * @ApiResource
 */
class AdsImages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

/**
     * @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $chemin; 

    /**
     * @ORM\ManyToOne(targetEntity=Ads::class, inversedBy="adsImages")
     */
    private $ads;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

public function getChemin(): ?string
    {
        return "https://store.jinukun.bj/uploads/images/farmers/".$this->path;
    }

    public function setChemin(?string $chemin): self
    {
        $this->chemin = $chemin;

        return $this;
    }

    public function getAds(): ?Ads
    {
        return $this->ads;
    }

    public function setAds(?Ads $ads): self
    {
        $this->ads = $ads;

        return $this;
    }


}
