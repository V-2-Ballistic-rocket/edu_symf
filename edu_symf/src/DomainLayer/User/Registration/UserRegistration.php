<?php

namespace App\DomainLayer\User\Registration;

use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use App\DomainLayer\Address\AddressDTO\SaveAddressDTO;
use App\DomainLayer\Storage\StorageManagerInterface;
use App\DomainLayer\User\Factory\UserFactory;
use App\DomainLayer\User\Profile\DTO\CreateProfileDTO;
use App\DomainLayer\User\Profile\DTO\SaveProfileDTO;
use App\DomainLayer\User\Registration\DTO\SavedUserDTO;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use App\DomainLayer\User\UserDTO\SaveUserDTO;
use App\DomainLayer\User\UserDTO\UserRegistrationDTO;
use Symfony\Component\Validator\Validation;

class UserRegistration
{
    public function registrationUser(
        UserRegistrationDTO $userRegistrationDTO,
        StorageManagerInterface $storageManager
    ) : SavedUserDTO
    {
        $userFactory = new UserFactory(Validation::createValidator());
        $user = $userFactory
            ->createUser(new CreateUserDTO(
                $userRegistrationDTO->login,
                $userRegistrationDTO->password,
                $userRegistrationDTO->email,
                $userRegistrationDTO->phoneNumber,
                new CreateProfileDTO(
                    $userRegistrationDTO->firstName,
                    $userRegistrationDTO->lastName,
                    $userRegistrationDTO->age,
                    $userRegistrationDTO->toAvatarPath
                ),
                new CreateAddressDTO(
                    $userRegistrationDTO->country,
                    $userRegistrationDTO->city,
                    $userRegistrationDTO->street,
                    $userRegistrationDTO->houseNumber
                )
            ));
        if(!$user)
        {
            throw new \Exception('Пользователь с такими данными не может быть сохранен.', 400);
        }
        return $storageManager->saveUser(new SaveUserDTO(
            $user->getLogin(),
            $user->getPassword(),
            $user->getEmail(),
            $user->getPhoneNumber(),
            new SaveProfileDTO(
                $user->getProfile()->getFirstName(),
                $user->getProfile()->getLastName(),
                $user->getProfile()->getAge(),
                $user->getProfile()->getAvatar(),
            ),
            new SaveAddressDTO(
                $user->getAddress()->getCountry(),
                $user->getAddress()->getCity(),
                $user->getAddress()->getStreet(),
                $user->getAddress()->getHouseNumber()
            )
        ));
    }
}