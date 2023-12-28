<?php

namespace App\InfrastructureLayer\Postgres\Entity;

use App\InfrastructureLayer\Postgres\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\Column]
    private ?string $id = null;

    #[ORM\Column(length: 30)]
    private ?string $login = null;

    #[ORM\Column(length: 30)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(name: "address_id", nullable: true, length: 255)]
    private ?string $addressId = null;

    #[ORM\Column(name: "profile_id", nullable: true, length: 255)]
    private ?string $profileId = null;

    #[ORM\Column(name: "token", nullable: true, length: 255)]
    private ?string $token = null;

    #[ORM\Column(name: "previous_version", nullable: true, length: 255)]
    private ?string $previousVersionId = null;

    #[ORM\Column(name: "confirm", type: "boolean")]
    private bool $confirmation = false;

    #[ORM\Column(name: "editdate", type: "datetime", nullable: true)]
    private ?\DateTimeInterface $editDate = null;

    /**
     * @param string|null $id
     * @param string|null $login
     * @param string|null $password
     * @param string|null $email
     * @param string|null $phone_number
     * @param \DateTimeInterface|null $editDate
     * @param string|null $addressId
     * @param string|null $profileId
     * @param string|null $token
     * @param boolean $confirmation
     * @param string|null $previousVersion
     */
    public function __construct(
        ?string $id = null,
        ?string $login = null,
        ?string $password = null,
        ?string $email = null,
        ?string $phone_number = null,
        ?\DateTimeInterface $editDate = null,
        ?string $addressId = null,
        ?string $profileId = null,
        ?string $token = null,
        bool $confirmation = false,
        ?string $previousVersion = null
    )
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->editDate = $editDate;
        $this->addressId = $addressId;
        $this->profileId = $profileId;
        $this->token = $token;
        $this->previousVersionId = $previousVersion;
        $this->confirmation = $confirmation;
    }

    public function setPreviousVersionId(?string $previousVersionId): void
    {

        $this->previousVersionId = $previousVersionId;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
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

    public function setAddressId(?string $addressId): static
    {
        $this->addressId = $addressId;

        return $this;
    }

    public function setProfileId(?string $profileId): static
    {
        $this->profileId = $profileId;

        return $this;
    }

    #[ORM\JoinColumn(name: "address_id", referencedColumnName: "id")]
    public function getAddressId(): ?string
    {
        return $this->addressId;

    }

    #[ORM\JoinColumn(name: "profile_id", referencedColumnName: "id")]
    public function getProfileId(): ?string
    {
        return $this->profileId;
    }

    public function setConfirmation(): static
    {
        $this->confirmation = true;

        return $this;
    }

    public function isConfirm(): bool
    {
        return $this->confirmation;
    }

    public function getPreviousVersionId(): ?string
    {
        return $this->previousVersionId;
    }
}
