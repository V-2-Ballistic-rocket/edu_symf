<?php

namespace App\InfrastructureLayer\User\DTO;

use Symfony\Component\Uid\Uuid;

readonly class GotUserDTO
{
    public function __construct(
        public ?Uuid $id = null,
        public string $firstName = "",
        public string $lastName = "",
        public int $age = 0,
        public string $email = "",
        public ?string $phoneNumber = ""
    )
    {}
}