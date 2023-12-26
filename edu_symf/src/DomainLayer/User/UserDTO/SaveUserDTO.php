<?php

namespace App\DomainLayer\User\UserDTO;
use App\DomainLayer\Address\AddressDTO\SaveAddressDTO;
use App\DomainLayer\User\Profile\DTO\SaveProfileDTO;

readonly class SaveUserDTO
{
    public function __construct(
        public ?string $id = null,
        public string $login = '',
        public string $password = '',
        public string $email = '',
        public ?string $phoneNumber = '',
        public ?SaveProfileDTO $saveProfileDTO = null,
        public ?SaveAddressDTO $saveAddressDTO = null,
        public bool $isConfirm = false
    )
    {}
}