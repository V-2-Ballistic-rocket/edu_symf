<?php

namespace App\DomainLayer\User\UserDTO;
use App\common\Validators as CustomAssert;
use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use App\DomainLayer\User\Profile\DTO\CreateProfileDTO;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserDTO
{
    public function __construct(
        public ?string $id = null,
        public string $login = '',
        public string $password = '',
        #[Assert\Email]
        public string  $email = '',
        #[CustomAssert\ContainPhoneNumber]
        public ?string $phoneNumber = '',
        public ?CreateProfileDTO $createProfileDTO = null,
        public ?CreateAddressDTO $createAddressDTO = null,
        public bool $isConfirm = false
    )
    {}
}