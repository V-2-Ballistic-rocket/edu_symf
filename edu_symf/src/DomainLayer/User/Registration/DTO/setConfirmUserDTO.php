<?php

namespace App\DomainLayer\User\Registration\DTO;

readonly class setConfirmUserDTO
{
    public function __construct(
        public string $token = ''
    )
    {
    }
}