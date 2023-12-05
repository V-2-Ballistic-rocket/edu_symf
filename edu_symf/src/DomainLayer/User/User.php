<?php

namespace App\DomainLayer\User;

use App\DomainLayer\User\UserDTO\CreateUserDTO;

class User
{
    private string $firstName;
    private string $lastName;
    public function  __construct(CreateUserDTO $createUserDTO)
    {
        $this->firstName = $createUserDTO->firstName;
        $this->lastName = $createUserDTO->lastName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }
}