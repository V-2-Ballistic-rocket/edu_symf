<?php

namespace App\DomainLayer\User\Registration\DataMappers;

use App\DomainLayer\Address\AddressDTO\SaveAddressDTO;
use App\DomainLayer\User\Profile\DTO\SaveProfileDTO;
use App\DomainLayer\User\User;
use App\DomainLayer\User\UserDTO\SaveUserDTO;

class UserMapper
{
    public function mapToSaveUserDto(User $user): SaveUserDto
    {
        return new SaveUserDTO(
            $user->getId(),
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
            ),
            $user->isConfirm()
        );
    }
}