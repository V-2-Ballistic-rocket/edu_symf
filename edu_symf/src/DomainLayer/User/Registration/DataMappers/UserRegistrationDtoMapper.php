<?php

namespace App\DomainLayer\User\Registration\DataMappers;

use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use App\DomainLayer\User\Profile\DTO\CreateProfileDTO;
use App\DomainLayer\User\Registration\DTO\UserRegistrationDTO;
use App\DomainLayer\User\UserDTO\CreateUserDTO;

class UserRegistrationDtoMapper
{
    public function mapToCreateUserDTO(UserRegistrationDTO $userRegistrationDTO): CreateUserDTO
    {
        return new CreateUserDTO(
            $userRegistrationDTO->id,
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
        );
    }
}