<?php

namespace App\DomainLayer\User;

use App\DomainLayer\User\CreateUserDTO;
use App\DomainLayer\User\User;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
class UserFactory
{
    public static function createUser(CreateUserDTO $createUserDTO) : ?User
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->addDefaultDoctrineAnnotationReader()
            ->getValidator();
        $errors = $validator->validate($createUserDTO);
        if(count($errors) > 0){
            $errorString = (string) $errors;
            return null;
        }
        return new User($createUserDTO);
    }
}