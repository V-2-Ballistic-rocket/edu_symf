<?php

namespace App\InfrastructureLayer\UserDTO;

readonly class EditUserDTO
{
    public function __construct(
        public string $firstName = "",
        public string $lastName = "",
        public ?int $id = null
    )
    {}
}