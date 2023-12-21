<?php

namespace App\InfrastructureLayer\Postgres\User\DataMappers;

use App\DomainLayer\Address\AddressDTO\AddressDTO;
use App\DomainLayer\User\Profile\DTO\ProfileDTO;
use App\DomainLayer\User\UserDTO\Collection\UserCollectionDtoMapperInterface;
use App\DomainLayer\User\UserDTO\Collection\UserDTO;
use App\DomainLayer\User\UserDTO\Collection\UserDtoCollection;

class UserCollectionMapper implements UserCollectionDtoMapperInterface
{
    public function mapFromArray(array $data): UserDtoCollection
    {
        $collection = new UserDtoCollection();
        foreach ($data as $key => $user){
            $collection[] = new UserDTO(
                $user['id'],
                $user['login'],
                $user['password'],
                $user['email'],
                $user['phone_number'],
                new ProfileDTO(
                    $user['profile']['id'],
                    $user['profile']['first_name'],
                    $user['profile']['last_name'],
                    $user['profile']['age'],
                    $user['profile']['to_avatar_path']
                ),
                new AddressDTO(
                    $user['address']['id'],
                    $user['address']['country'],
                    $user['address']['city'],
                    $user['address']['street'],
                    $user['address']['house_number']
                )
            );
        }
        return $collection;
    }

    public function mapToArray(UserDtoCollection $userDtoCollection): array
    {
        $collection = [];

        foreach ($userDtoCollection as $key => $user)
        {
            $collection[] = [
                'id' => $user->id,
                'login' => $user->login,
                'password' => $user->password,
                'email' => $user->email,
                'phone_number' => $user->phoneNumber,
                'profile' => [
                    $user->profile->id,
                    $user->profile->firstName,
                    $user->profile->lastName,
                    $user->profile->age,
                    $user->profile->toAvatarPath
                ],
                'address' => [
                    $user->address->id,
                    $user->address->country,
                    $user->address->city,
                    $user->address->street,
                    $user->address->houseNumber
                ]
            ];
        }
        return $collection;
    }

    public function MapToJson(UserDtoCollection $userDtoCollection): string
    {
        return json_encode($this->mapToArray($userDtoCollection), JSON_UNESCAPED_UNICODE);
    }
}