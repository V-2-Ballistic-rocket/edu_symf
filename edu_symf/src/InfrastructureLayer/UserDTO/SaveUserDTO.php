<?php

namespace App\InfrastructureLayer\UserDTO;

readonly class SaveUserDTO
{
    public function __construct(
        public string $firstName = "",
        public string $lastName = "",
        public int $age = 0,
        public string $email = "",
        public ?string $phoneNumber = ""
    )
    {}
}