<?php

namespace App\DomainLayer\User\Profile\DTO;

use Symfony\Component\Uid\Uuid;

class ProfileDTO
{
    public function __construct(
        public string|null|Uuid $id = null,
        public string $firstName = '',
        public string $lastName = '',
        public int $age = 0,
        public ?string $toAvatarPath = null
    )
    {
    }
}