<?php

namespace App\InfrastructureLayer\Postgres\User\Profile\DTO;

use App\DomainLayer\User\Profile\Avatar\Avatar;

readonly class ProfileDTO
{
    public function __construct(
        public string $firstName = '',
        public string $lastName = '',
        public int $age = 0,
        public ?Avatar $avatar = null
    )
    {}
}