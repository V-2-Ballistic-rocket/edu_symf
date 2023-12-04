<?php

namespace App\InfrastructureLayer\UserDTO;

readonly class DeleteUserDTO
{
    public function __construct(
        public ?int $id = null
    )
    {}
}