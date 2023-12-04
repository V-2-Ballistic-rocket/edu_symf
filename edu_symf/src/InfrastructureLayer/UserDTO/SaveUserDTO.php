<?php

namespace App\InfrastructureLayer\UserDTO;

readonly class SaveUserDTO
{
    public function __construct(
        public string $firstName = "",
        public string $lastName = ""
    )
    {}
}