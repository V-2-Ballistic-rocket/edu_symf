<?php

namespace App\InfrastructureLayer\Postgres;

readonly class SaveUserDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName
    )
    {
    }
}