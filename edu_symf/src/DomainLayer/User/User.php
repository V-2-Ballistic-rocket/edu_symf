<?php

namespace App\DomainLayer\User;

use App\DomainLayer\User\UserDTO\CreateUserDTO;

class User
{
    public string $firstName = "";
    public string $lastName = "";
    public int $age = 0;
    public string $email = "";
    public ?string $phoneNumber = "";
    public function  __construct(CreateUserDTO $createUserDTO)
    {
        $this->firstName = $createUserDTO->firstName;
        $this->lastName = $createUserDTO->lastName;
        $this->age = $createUserDTO->age;
        $this->email = $createUserDTO->email;
        $this->phoneNumber = $createUserDTO->phoneNumber;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

}