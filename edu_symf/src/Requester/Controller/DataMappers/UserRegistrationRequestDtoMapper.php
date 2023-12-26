<?php

namespace App\Requester\Controller\DataMappers;

use App\DomainLayer\User\Registration\DTO\UserRegistrationDTO;
use App\Requester\Controller\DTO\UserRegistrationRequestDTO;

class UserRegistrationRequestDtoMapper
{
    public function mapToUserRegistrationDto(UserRegistrationRequestDTO $dto): UserRegistrationDTO
    {

        return new UserRegistrationDTO(
            $dto->login,
            $dto->password,
            $dto->email,
            $dto->phoneNumber,
            $dto->firstName,
            $dto->lastName,
            $dto->age,
            $dto->pathToAvatar,
            $dto->country,
            $dto->city,
            $dto->street,
            $dto->houseNumber
        );
    }
}