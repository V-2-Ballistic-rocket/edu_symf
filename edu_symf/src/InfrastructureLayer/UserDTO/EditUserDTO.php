<?php

namespace App\InfrastructureLayer\UserDTO;

use Symfony\Component\Uid\Uuid;

readonly class EditUserDTO
{
    public function __construct(
        public string $firstName = "",
        public string $lastName = "",
        public ?Uuid $id = null
    )
    {}
}