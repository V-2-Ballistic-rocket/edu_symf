<?php

namespace App\DomainLayer\User\Profile;

use App\DomainLayer\User\Profile\Avatar\Avatar;

class Profile
{
    public function __construct(
        private string $firstName = '',
        private string $lastName = '',
        private int $age = 0,
        private ?Avatar $avatar = null
    )
    {}

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }


}