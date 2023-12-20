<?php

namespace App\DomainLayer\User\Registration\DTO;

readonly class ConfirmRegistrationDTO
{
    public function __construct(
        public string $token = ''
    )
    {
    }
}