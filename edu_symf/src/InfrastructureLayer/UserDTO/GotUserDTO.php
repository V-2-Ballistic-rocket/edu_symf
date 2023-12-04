<?php

namespace App\InfrastructureLayer\UserDTO;

readonly class GotUserDTO
{
    public function __construct(
        public string $firstName = "",
        public string $lastName = ""
    )
    {}
}