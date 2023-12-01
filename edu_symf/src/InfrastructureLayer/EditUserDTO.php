<?php

namespace App\InfrastructureLayer;

readonly class EditUserDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public int $id
    )
    {}
}