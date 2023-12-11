<?php

namespace App\DomainLayer\User\UserDTO;

use App\common\Validators as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;
readonly class CreateUserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string  $firstName = "",
        #[CustomAssert\ContainFio]
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