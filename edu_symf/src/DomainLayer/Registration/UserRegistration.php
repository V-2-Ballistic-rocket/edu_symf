<?php

namespace App\DomainLayer\Registration;

use App\DomainLayer\Factory\UserFactory;
use App\DomainLayer\UserDTO\CreateUserDTO;
use App\DomainLayer\UserDTO\UserRegistrationDTO;
use App\InfrastructureLayer\StorageManagerInterface;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use Symfony\Component\Validator\Validation;

class UserRegistration
{

    public function registrationUser(UserRegistrationDTO $userRegistrationDTO, StorageManagerInterface $storageManager) : int
    {
        $userFactory = new UserFactory(Validation::createValidator());

        $user = $userFactory
            ->createUser(new CreateUserDTO($userRegistrationDTO->firstName, $userRegistrationDTO->lastName));

        $id = $storageManager->saveUser(new SaveUserDTO($user->getFirstName(), $user->getLastName()))
            ->id;

        return $id;
    }
}