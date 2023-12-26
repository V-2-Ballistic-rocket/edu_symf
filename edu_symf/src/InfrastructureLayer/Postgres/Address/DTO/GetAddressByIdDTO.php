<?php

namespace App\InfrastructureLayer\Postgres\Address\DTO;

readonly class GetAddressByIdDTO
{
    public function __construct(
        public string $id = ''
    )
    {}
}