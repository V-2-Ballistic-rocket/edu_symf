<?php

namespace App\InfrastructureLayer\UserDTO;

class SavedUserDTO
{
    public function __construct(
        public ?int $id = null
    ){}
}