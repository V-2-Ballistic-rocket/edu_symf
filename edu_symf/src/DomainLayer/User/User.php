<?php

namespace App\DomainLayer\User;

use App\DomainLayer\Address\Address;
use App\DomainLayer\User\Profile\Profile;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use Symfony\Component\Uid\Uuid;

class User
{
    public function  __construct(
        private null|string $id = null,
        private string $login = '',
        private string $password = '',
        private string $email = '',
        private ?string $phoneNumber = '',
        private ?Profile $profile = null,
        private ?Address $address = null,
        private bool $isConfirm = false
    )
    {}

    public function getId(): ?string
    {
        return $this->id;
    }
    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function isConfirm(): bool
    {
        return $this->isConfirm;
    }

    public function setIsConfirm(bool $isConfirm): void
    {
        $this->isConfirm = $isConfirm;
    }
}