<?php

namespace App\Entity;

use App\Repository\ProduitImagesRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=ProduitImagesRepository::class)
 * @Vich\Uploadable
 */
class ProduitImages
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
    private $chemin;

    /**
     * @Vich\UploadableField(mapping="chemins", fileNameProperty="chemin")
     * @var File
     */
    private $imageFile;


    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="ImagesAutres")
     */
    private $produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChemin(): ?string
    {
        return $this->chemin;
    }

    public function setChemin(?string $chemin): self
    {
        $this->chemin = $chemin;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

//        if ($image) {
//            $this->updated_at = new \DateTime('now');
//        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }
}
