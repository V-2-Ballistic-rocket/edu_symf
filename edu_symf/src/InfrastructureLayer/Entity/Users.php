<?php

namespace App\InfrastructureLayer\Entity;

use App\InfrastructureLayer\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\Column]
    private null|Uuid $id = null;

    #[ORM\Column(length: 30)]
    private ?string $login = null;

    #[ORM\Column(length: 30)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    private ?string $phone_number = null;

    #[ORM\Column(name: "address_id", type: "uuid", nullable: true)]
    private null|Uuid $addressId;

    #[ORM\Column(name: "profile_id", type: "uuid", nullable: true)]
    private null|Uuid $profileId;

    /**
     * @param Uuid|null $id
     * @param string|null $login
     * @param string|null $password
     * @param string|null $email
     * @param string|null $phone_number
     * @param null|Uuid $addressId
     * @param null|Uuid $profileId
     */
    public function __construct(
        null|Uuid $id = null,
        ?string $login = null,
        ?string $password = null,
        ?string $email = null,
        ?string $phone_number = null,
        null|Uuid $addressId = null,
        null|Uuid $profileId = null
    )
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->addressId = $addressId;
        $this->profileId = $profileId;
    }

    public function getId(): null|Uuid
    {
        return $this->id;
    }

    public function setId(null|Uuid $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

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

    public function setAddressId(null|Uuid $addressId): static
    {
        $this->addressId = $addressId;

        return $this;
    }

    public function setProfileId(null|Uuid $profileId): static
    {
        $this->profileId = $profileId;

        return $this;
    }

    #[ORM\JoinColumn(name: "address_id", referencedColumnName: "id")]
    public function getAddressId(): null|Uuid
    {
        return $this->addressId;

    }

    #[ORM\JoinColumn(name: "profile_id", referencedColumnName: "id")]
    public function getProfileId(): null|Uuid
    {
        return $this->profileId;
    }
}
