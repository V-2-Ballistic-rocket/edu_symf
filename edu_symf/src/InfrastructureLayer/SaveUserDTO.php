<?php

namespace App\InfrastructureLayer;

readonly class SaveUserDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName
    )
    {}
}