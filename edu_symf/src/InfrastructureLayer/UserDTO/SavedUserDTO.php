<?php

namespace App\InfrastructureLayer\UserDTO;

use Symfony\Component\Uid\Uuid;

class SavedUserDTO
{
    public function __construct(
        public ?Uuid $id = null
    ){}
}