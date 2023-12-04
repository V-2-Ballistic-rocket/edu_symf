<?php

namespace App\DomainLayer\UserDTO;

class UserRegistrationDTO
{
    public function __construct(
        public string $firstName = "",
        public string $lastName = ""
    )
    {}
}