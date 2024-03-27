<?php

namespace App\Requester\Controller\DTO;

readonly class UserRegistrationRequestDTO
{
    public function __construct(
        public mixed $login = '',
        public mixed $password = '',
        public mixed $email = '',
        public mixed $phone_number = '',
        public mixed $first_name = '',
        public mixed $last_name = '',
        public mixed $age = 0,
        public mixed $path_to_avatar = '',
        public mixed $country = '',
        public mixed $city = '',
        public mixed $street = '',
        public mixed $house_number = ''
    )
    {}
}