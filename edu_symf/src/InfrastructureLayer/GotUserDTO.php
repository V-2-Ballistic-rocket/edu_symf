<?php

namespace App\InfrastructureLayer;

readonly class GotUserDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName
    )
    {}
}