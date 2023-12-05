<?php

namespace App\InfrastructureLayer\UserDTO;

use Symfony\Component\Uid\Uuid;

readonly class DeleteUserDTO
{
    public function __construct(
        public ?Uuid $id = null
    )
    {}
}