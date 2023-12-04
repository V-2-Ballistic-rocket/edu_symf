<?php

namespace App\DomainLayer\Factory;

use App\DomainLayer\User\User;
use App\DomainLayer\UserDTO\CreateUserDTO;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactory
{
    public function __construct(
        public ValidatorInterface $validator
    )
    {

    }

    public function createUser(CreateUserDTO $createUserDTO) : ?User
    {

        $errors = $this->validator->validate($createUserDTO);
        if(count($errors) > 0){
            $errorString = (string) $errors;
            return null;
        }
        return new User($createUserDTO);
    }
}