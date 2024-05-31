<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArtillerieRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ArtillerieRepository::class)]
class Artillerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    private ?string $Nom = null;

    #[ORM\Column]
    private ?int $tier = null;

    #[ORM\Column]
    private ?int $poids = null;

    #[Vich\UploadableField(mapping: 'artilleries', fileNameProperty: 'imageName')]
    #[Assert\Image(
        mimeTypes: ['image/*'],
        maxSize: '3M',
        detectCorrupted: true,
    )]
    private ?File $image = null;
    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getTier(): ?int
    {
        return $this->tier;
    }

    public function setTier(int $tier): static
    {
        $this->tier = $tier;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function setImage(?File $imageFile = null): static
    {
        $this->image = $imageFile;

        if (null !== $imageFile)

            return $this;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
}
