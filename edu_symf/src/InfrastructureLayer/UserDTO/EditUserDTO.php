<?php

namespace App\InfrastructureLayer\UserDTO;

use Symfony\Component\Uid\Uuid;

readonly class EditUserDTO
{
    public function __construct(
        public string $firstName = "",
        public string $lastName = "",
        public int $age = 0,
        public string $email = "",
        public ?string $phoneNumber = "",
        public ?Uuid $id = null
    )
    {}
}