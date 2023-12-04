<?php

namespace App\InfrastructureLayer\UserDTO;

class GetUserDTO
{
    public function __construct(
        public ?int $id = null
    )
    {}
}