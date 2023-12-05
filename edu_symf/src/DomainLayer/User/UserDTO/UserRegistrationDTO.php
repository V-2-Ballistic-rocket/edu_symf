<?php

namespace App\DomainLayer\User\UserDTO;

class UserRegistrationDTO
{
    public function __construct(
        public string $firstName = "",
        public string $lastName = ""
    )
    {}
}