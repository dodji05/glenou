<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 *  @Vich\Uploadable
 */
class Articles
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
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenu;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $udpdateAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagesprincipale;

    /**
     * @Vich\UploadableField(mapping="articles", fileNameProperty="imagesprincipale")
     * @var File
     */
    private $imageArticles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Slug;

    /**
     * @ORM\ManyToOne(targetEntity=CategoriesArticles::class, inversedBy="articles")
     */
    private $categories;

    /**
     * Articles constructor.
     * @param $createdAt
     * @param $udpdateAt
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->udpdateAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUdpdateAt(): ?\DateTimeInterface
    {
        return $this->udpdateAt;
    }

    public function setUdpdateAt(\DateTimeInterface $udpdateAt): self
    {
        $this->udpdateAt = $udpdateAt;

        return $this;
    }

    public function getImagesprincipale(): ?string
    {
        return $this->imagesprincipale;
    }

    public function setImagesprincipale(string $imagesprincipale): self
    {
        $this->imagesprincipale = $imagesprincipale;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->Slug;
    }

    public function setSlug(?string $Slug): self
    {
        $this->Slug = $Slug;

        return $this;
    }

    public function getCategories(): ?CategoriesArticles
    {
        return $this->categories;
    }

    public function setCategories(?CategoriesArticles $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function setImageArticles(File $image = null)
    {
        $this->imageArticles = $image;

//        if ($image) {
//            $this->updated_at = new \DateTime('now');
//        }
    }

    public function getImageArticles()
    {
        return $this->imageArticles;
    }

}
