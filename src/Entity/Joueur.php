<?php

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\JoueurRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé par un autre compte')]
class Joueur implements PasswordAuthenticatedUserInterface
{

    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    private ?string $discord = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $level = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getDiscord(): ?string
    {
        return $this->discord;
    }

    public function setDiscord(string $discord): static
    {
        $this->discord = $discord;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }
}
