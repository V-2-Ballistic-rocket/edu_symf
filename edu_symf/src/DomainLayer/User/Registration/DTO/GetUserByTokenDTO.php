<?php

namespace App\DomainLayer\User\Registration\DTO;

readonly class GetUserByTokenDTO
{
    public function __construct(
        public string $token = ''
    )
    {}
}