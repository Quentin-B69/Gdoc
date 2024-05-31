<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $grade = null;

    /**
     * @var Collection<int, joueur>
     */
    #[ORM\OneToMany(targetEntity: joueur::class, mappedBy: 'grade')]
    private Collection $gradejoueur;

    public function __construct()
    {
        $this->gradejoueur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return Collection<int, joueur>
     */
    public function getGradejoueur(): Collection
    {
        return $this->gradejoueur;
    }

    public function addGradejoueur(joueur $gradejoueur): static
    {
        if (!$this->gradejoueur->contains($gradejoueur)) {
            $this->gradejoueur->add($gradejoueur);
            $gradejoueur->setGrade($this);
        }

        return $this;
    }

    public function removeGradejoueur(joueur $gradejoueur): static
    {
        if ($this->gradejoueur->removeElement($gradejoueur)) {
            // set the owning side to null (unless already changed)
            if ($gradejoueur->getGrade() === $this) {
                $gradejoueur->setGrade(null);
            }
        }

        return $this;
    }
}
