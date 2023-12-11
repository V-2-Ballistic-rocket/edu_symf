<?php

namespace App\DomainLayer\User\UserDTO;
use App\common\Validators as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserDTO
{
    public function __construct(
        #[CustomAssert\ContainProperName]
        public string  $firstName = "",
        #[CustomAssert\ContainProperName]
        public string  $lastName = "",
        #[CustomAssert\ContainAge]
        public int     $age = 0,
        #[Assert\Email]
        public string  $email = "",
        #[CustomAssert\ContainPhoneNumber]
        public ?string $phoneNumber = "",
    )
    {
    }
}