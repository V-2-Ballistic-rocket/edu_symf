<?php

namespace App\InfrastructureLayer\Postgres\Entity;

use App\InfrastructureLayer\Postgres\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\Column]
    private null|string|Uuid $id = null;

    #[ORM\Column(length: 30)]
    private ?string $first_name = null;

    #[ORM\Column(length: 30)]
    private ?string $last_name = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $to_avatar_path = null;

    public function __construct(
        null|string|Uuid $id = null,
        ?string $first_name = '',
        ?string $last_name = '',
        ?int $age = 0,
        ?string $to_avatar_path = ''
    )
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->age = $age;
        $this->to_avatar_path = $to_avatar_path;
    }

    public function getId(): null|string|Uuid
    {
        return $this->id;
    }

    public function setId(null|string|Uuid $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getToAvatarPath(): ?string
    {
        return $this->to_avatar_path;
    }

    public function setToAvatarPath(?string $to_avatar_path): static
    {
        $this->to_avatar_path = $to_avatar_path;

        return $this;
    }
}
