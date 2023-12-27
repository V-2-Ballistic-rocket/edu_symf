<?php

namespace App\DomainLayer\User\Registration\DTO;

use Symfony\Component\Uid\Uuid;

class SavedUserDTO
{
    public function __construct(
        public ?string $id = null,
        public ?string $confirmRegistrationToken = null,
        public ?string $email = null
    ){}
}