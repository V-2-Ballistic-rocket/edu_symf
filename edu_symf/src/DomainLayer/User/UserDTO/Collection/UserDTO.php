<?php

namespace App\DomainLayer\User\UserDTO\Collection;

use App\DomainLayer\Address\AddressDTO\AddressDTO;
use App\DomainLayer\User\Profile\DTO\ProfileDTO;
use Symfony\Component\Uid\Uuid;

readonly class UserDTO
{
    public function __construct(
        public ?Uuid $id = null,
        public string $login = "",
        public string $password = "",
        public string $email = "",
        public ?string $phoneNumber = "",
        public ?ProfileDTO $profile = null,
        public ?AddressDTO $address = null
    )
    {}
}