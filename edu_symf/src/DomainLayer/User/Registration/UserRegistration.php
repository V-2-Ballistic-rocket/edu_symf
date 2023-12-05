<?php

namespace App\DomainLayer\User\Registration;

use App\DomainLayer\StorageManagerInterface;
use App\DomainLayer\User\Factory\UserFactory;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use App\DomainLayer\User\UserDTO\UserRegistrationDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validation;

class UserRegistration
{

    public function registrationUser(UserRegistrationDTO $userRegistrationDTO, StorageManagerInterface $storageManager) : Uuid
    {
        $userFactory = new UserFactory(Validation::createValidator());

        $user = $userFactory
            ->createUser(new CreateUserDTO($userRegistrationDTO->firstName, $userRegistrationDTO->lastName));

        $id = $storageManager->saveUser(new SaveUserDTO($user->getFirstName(), $user->getLastName()))
            ->id;

        return $id;
    }
}