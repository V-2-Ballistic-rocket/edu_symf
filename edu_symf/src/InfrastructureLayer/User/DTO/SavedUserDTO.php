<?php

namespace App\InfrastructureLayer\User\DTO;

use Symfony\Component\Uid\Uuid;

class SavedUserDTO
{
    public function __construct(
        public null|string|Uuid $id = null
    ){}
}