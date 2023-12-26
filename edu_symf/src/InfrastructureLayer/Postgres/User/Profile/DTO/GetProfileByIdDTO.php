<?php

namespace App\InfrastructureLayer\Postgres\User\Profile\DTO;

readonly class GetProfileByIdDTO
{
    public function __construct(
        public string $id = ''
    )
    {}
}