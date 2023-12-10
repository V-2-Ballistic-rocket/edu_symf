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
    public function registrationUser(UserRegistrationDTO $userRegistrationDTO, StorageManagerInterface $storageManager) : uuid
    {
        $userFactory = new UserFactory(Validation::createValidator());
        $user = $userFactory
            ->createUser(new CreateUserDTO(
                $userRegistrationDTO->firstName,
                $userRegistrationDTO->lastName,
                $userRegistrationDTO->age,
                $userRegistrationDTO->email,
                $userRegistrationDTO->phoneNumber
            ));
        if(!$user)
        {
            throw new \Exception('Пользователь с такими данными не может быть сохранен.', 400);
        }
        return $storageManager->saveUser(new SaveUserDTO(
            $user->getFirstName(),
            $user->getLastName(),
            $user->getAge(),
            $user->getEmail(),
            $user->getPhoneNumber()
        ))->id;
    }
}