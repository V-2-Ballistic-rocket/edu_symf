<?php

namespace App\DomainLayer\User\UserDTO;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserDTO
{
    public function __construct(
        /**
         * @Assert\NotBlank
         */
        public string $firstName = "",
        #[Assert\NotBlank]
        public string $lastName = ""
    )
    {}
}