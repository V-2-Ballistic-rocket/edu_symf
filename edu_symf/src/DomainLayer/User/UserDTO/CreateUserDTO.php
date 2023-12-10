<?php

namespace App\DomainLayer\User\UserDTO;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $firstName = "",
        #[Assert\NotBlank]
        public string $lastName = "",
        #[Assert\NotBlank]
        public int $age = 0,
        #[Assert\NotBlank]
        public string $email = "",
        public ?string $phoneNumber = "",
    )
    {}
}