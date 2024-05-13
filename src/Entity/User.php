<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    normalizationContext: ['groups' => ['read_user']],
    denormalizationContext: ['groups' => ['write_user']],
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['read_user']]
        ),
        new Post (
            denormalizationContext: ['groups' => ['write_user']]
        )
    ]
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_user'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_user', 'write_user'])]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Groups(['write_user'])]
    private ?string $password = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups(['read_user', 'write_user'])]
    private array $role = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): static
    {
        $this->role = $role;

        return $this;
    }
}
