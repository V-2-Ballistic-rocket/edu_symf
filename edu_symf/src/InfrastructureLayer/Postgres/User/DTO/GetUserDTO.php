<?php

namespace App\InfrastructureLayer\Postgres\User\DTO;

use Symfony\Component\Uid\Uuid;

class GetUserDTO
{
    public function __construct(
        public ?Uuid $id = null
    )
    {}
}