<?php

namespace App\DomainLayer\User\UserDTO\Collection;

use Symfony\Component\Uid\Uuid;

readonly class UserDTO
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