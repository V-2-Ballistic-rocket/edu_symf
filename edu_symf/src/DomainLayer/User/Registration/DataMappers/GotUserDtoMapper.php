<?php

namespace App\DomainLayer\User\Registration\DataMappers;

use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use App\DomainLayer\User\Profile\DTO\CreateProfileDTO;
use App\DomainLayer\User\Registration\DTO\GotUserDTO;
use App\DomainLayer\User\Registration\DTO\UserRegistrationDTO;
use App\DomainLayer\User\UserDTO\CreateUserDTO;

class GotUserDtoMapper
{
    public function mapToUserRegistrationDto(GotUserDTO $gotUserDto): UserRegistrationDTO
    {
        return new UserRegistrationDTO(
            $gotUserDto->login,
            $gotUserDto->password,
            $gotUserDto->email,
            $gotUserDto->phoneNumber,
            $gotUserDto->firstName,
            $gotUserDto->lastName,
            $gotUserDto->age,
            $gotUserDto->toAvatarPath,
            $gotUserDto->country,
            $gotUserDto->city,
            $gotUserDto->street,
            $gotUserDto->houseNumber,
            $gotUserDto->id
        );
    }

    public function mapToCreateUserDTO(GotUserDTO $gotUserDTO): CreateUserDTO
    {
        return new CreateUserDTO(
            $gotUserDTO->id,
            $gotUserDTO->login,
            $gotUserDTO->password,
            $gotUserDTO->email,
            $gotUserDTO->phoneNumber,
            new CreateProfileDTO(
                $gotUserDTO->firstName,
                $gotUserDTO->lastName,
                $gotUserDTO->age,
                $gotUserDTO->toAvatarPath
            ),
            new CreateAddressDTO(
                $gotUserDTO->country,
                $gotUserDTO->city,
                $gotUserDTO->street,
                $gotUserDTO->houseNumber
            ),
            $gotUserDTO->isConfirm
        );
    }
}