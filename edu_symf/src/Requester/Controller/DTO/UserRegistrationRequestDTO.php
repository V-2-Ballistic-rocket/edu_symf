<?php

namespace App\Requester\Controller\DTO;

readonly class UserRegistrationRequestDTO
{
    public function __construct(
        public mixed $firstName = "",
        public mixed $lastName = "",
        public mixed $age = 0,
        public mixed $email = "",
        public mixed $phoneNumber = ""
    )
    {}
}