<?php

namespace App\DomainLayer\User\Registration\DTO;

readonly class GotUserDTO
{
    public function __construct(
        public string $id = '',
        public string $login = '',
        public string $password = '',
        public string $email = "",
        public ?string $phoneNumber = "",
        public bool $isConfirm = false,
        public string $firstName = "",
        public string $lastName = "",
        public int $age = 0,
        public string $toAvatarPath = '',
        public string $country = '',
        public string $city = '',
        public string $street = '',
        public string $houseNumber = '',
    )
    {}
}