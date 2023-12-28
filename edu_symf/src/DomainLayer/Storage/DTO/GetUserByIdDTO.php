<?php

namespace App\DomainLayer\Storage\DTO;

readonly class GetUserByIdDTO
{
    public function __construct(
        public string $id = ''
    )
    {
    }


}