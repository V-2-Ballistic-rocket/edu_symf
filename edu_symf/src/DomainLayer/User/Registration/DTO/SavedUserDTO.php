<?php

namespace App\DomainLayer\User\Registration\DTO;

use Symfony\Component\Uid\Uuid;

class SavedUserDTO
{
    public function __construct(
        public null|string|Uuid $id = null
    ){}
}