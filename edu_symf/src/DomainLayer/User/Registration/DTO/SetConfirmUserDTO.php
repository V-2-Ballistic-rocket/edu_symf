<?php

namespace App\DomainLayer\User\Registration\DTO;

readonly class SetConfirmUserDTO
{
    public function __construct(
        public string $token = ''
    )
    {
    }
}