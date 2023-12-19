<?php

namespace App\Requester\Controller\DTO;

readonly class UserRegistrationRequestDTO
{
    public function __construct(
        public mixed $login = '',
        public mixed $password = '',
        public mixed $email = '',
        public mixed $phoneNumber = '',
        public mixed $firstName = '',
        public mixed $lastName = '',
        public mixed $age = 0,
        public mixed $pathToAvatar = '',
        public mixed $country = '',
        public mixed $city = '',
        public mixed $street = '',
        public mixed $houseNumber = ''
    )
    {}
}