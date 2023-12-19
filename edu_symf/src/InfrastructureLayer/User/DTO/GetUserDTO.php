<?php

namespace App\InfrastructureLayer\User\DTO;

use Symfony\Component\Uid\Uuid;

class GetUserDTO
{
    public function __construct(
        public ?Uuid $id = null
    )
    {}
}