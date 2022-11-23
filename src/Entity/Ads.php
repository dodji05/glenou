<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdsRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=AdsRepository::class)
* @ApiResource(
*     normalizationContext={"groups"={"ads:read"}},
 *     denormalizationContext={"groups"={"ads:write"}},
* )
 */
class Ads
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255)
     */
    private $prix;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $disponibilite;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Stock;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $localisation;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qteDisponible;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mesure;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prixCession;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $whatsapp;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\ManyToOne(targetEntity=AdsCategorie::class, inversedBy="ads")
     */
    private $categorie;



    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\OneToMany(targetEntity=AdsImages::class, mappedBy="ads")
     */
    private $adsImages;


    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ads")
     */
    private $users;

    /**
* @Groups({"ads:read", "ads:write"})
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
* @Groups({"ads:read", "ads:write"})

     * @Gedmo\Slug(fields={"title"})

     * @ORM\Column(type="string", length=255, nullable=true, unique=true)

     */

    private $slug;

    public function __construct()
    {
        $this->adsImages = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?string $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->Stock;
    }

    public function setStock(?string $Stock): self
    {
        $this->Stock = $Stock;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getQteDisponible(): ?string
    {
        return $this->qteDisponible;
    }

    public function setQteDisponible(?string $qteDisponible): self
    {
        $this->qteDisponible = $qteDisponible;

        return $this;
    }

    public function getMesure(): ?string
    {
        return $this->mesure;
    }

    public function setMesure(?string $mesure): self
    {
        $this->mesure = $mesure;

        return $this;
    }

    public function getPrixCession(): ?string
    {
        return $this->prixCession;
    }

    public function setPrixCession(?string $prixCession): self
    {
        $this->prixCession = $prixCession;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getWhatsapp(): ?string
    {
        return $this->whatsapp;
    }

    public function setWhatsapp(?string $whatsapp): self
    {
        $this->whatsapp = $whatsapp;

        return $this;
    }

    public function getCategorie(): ?AdsCategorie
    {
        return $this->categorie;
    }

    public function setCategorie(?AdsCategorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }



    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|AdsImages[]
     */
    public function getAdsImages(): Collection
    {
        return $this->adsImages;
    }

    public function addAdsImage(AdsImages $adsImage): self
    {
        if (!$this->adsImages->contains($adsImage)) {
            $this->adsImages[] = $adsImage;
            $adsImage->setAds($this);
        }

        return $this;
    }

    public function removeAdsImage(AdsImages $adsImage): self
    {
        if ($this->adsImages->removeElement($adsImage)) {
            // set the owning side to null (unless already changed)
            if ($adsImage->getAds() === $this) {
                $adsImage->setAds(null);
            }
        }

        return $this;
    }

     public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getSlug(): ?string

    {

        return $this->slug;

    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
