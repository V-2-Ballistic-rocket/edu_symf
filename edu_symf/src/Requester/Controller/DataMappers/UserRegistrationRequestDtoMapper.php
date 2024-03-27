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
            $dto->phone_number,
            $dto->first_name,
            $dto->last_name,
            $dto->age,
            $dto->path_to_avatar,
            $dto->country,
            $dto->city,
            $dto->street,
            $dto->house_number
        );
    }
}