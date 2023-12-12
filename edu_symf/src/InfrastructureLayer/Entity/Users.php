<?php

namespace App\InfrastructureLayer\Entity;

use App\InfrastructureLayer\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use http\Message;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\Column]
    private null|Uuid|string $id = null;

    #[ORM\Column(length: 30)]
    private ?string $first_name = null;

    #[ORM\Column(length: 30)]
    private ?string $last_name = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    private ?string $phone_number = null;

    /**
     * @param Uuid|null $id
     * @param string|null $first_name
     * @param string|null $last_name
     * @param int|null $age
     * @param string|null $email
     * @param string|null $phone_number
     */
    public function __construct(null|Uuid|string $id = null, ?string $first_name = null, ?string $last_name = null, ?int $age = null, ?string $email = null, ?string $phone_number = null)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->age = $age;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }


    public function getId(): null|Uuid|string
    {
        return $this->id;
    }

    public function setId(null|Uuid|string $id): static
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }
}
