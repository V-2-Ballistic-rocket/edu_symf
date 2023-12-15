<?php

namespace App\InfrastructureLayer\Entity;

use App\InfrastructureLayer\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\Column]
    private null|string|Uuid $id = null;

    #[ORM\Column(length: 50)]
    private ?string $country = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column(length: 150)]
    private ?string $street = null;

    #[ORM\Column(length: 15)]
    private ?string $house_number = null;

    public function __construct(
        null|string|Uuid $id = null,
        string $country = '',
        string $city = '',
        string $street = '',
        string $house_number = ''
    )
    {
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
    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return $this->house_number;
    }

    public function setHouseNumber(string $house_number): static
    {
        $this->house_number = $house_number;

        return $this;
    }
}
