<?php

namespace App\DomainLayer\User\Registration;

use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use App\DomainLayer\Address\AddressDTO\SaveAddressDTO;
use App\DomainLayer\Storage\StorageManagerInterface;
use App\DomainLayer\User\Exceptions\ConfirmUserException;
use App\DomainLayer\User\Exceptions\CreateUserException;
use App\DomainLayer\User\Factory\UserFactory;
use App\DomainLayer\User\Profile\DTO\CreateProfileDTO;
use App\DomainLayer\User\Profile\DTO\SaveProfileDTO;
use App\DomainLayer\User\Registration\DTO\setConfirmUserDTO;
use App\DomainLayer\User\Registration\DTO\SavedUserDTO;
use App\DomainLayer\User\Registration\DTO\UserRegistrationDTO;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use App\DomainLayer\User\UserDTO\SaveUserDTO;
use Symfony\Component\Validator\Validation;

class UserRegistration
{
    public function __construct(
        private ?StorageManagerInterface $storageManager = null
    )
    {
    }

    public function registrationUser(
        UserRegistrationDTO $userRegistrationDTO
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
                ),
                $userRegistrationDTO->id,
            ));

        try {
            $savedUserDto = $this->storageManager->saveUser(new SaveUserDTO(
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
        } catch (\Exception $exception)
        {
            throw new CreateUserException();
        }

        return $savedUserDto;
    }

    public function confirmRegistration(setConfirmUserDTO $confirmRegistrationDTO): void
    {
        try {
            $this->storageManager->confirmRegistration($confirmRegistrationDTO);
        } catch (\Exception $e) {
            throw new ConfirmUserException();
        }
    }
}