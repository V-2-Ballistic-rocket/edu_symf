<?php

namespace App\InfrastructureLayer\User\DataMappers;

use App\DomainLayer\User\UserDTO\Collection\UserCollectionDtoMapperInterface;
use App\DomainLayer\User\UserDTO\Collection\UserDtoCollection;
use App\DomainLayer\User\UserDTO\Collection\UserDTO;
use App\Requester\Controller\UserController;
use Symfony\Component\Uid\Uuid;

class UserCollectionMapper implements UserCollectionDtoMapperInterface
{
    public function mapFromArray(array $data): UserDtoCollection
    {
        $collection = new UserDtoCollection();
        foreach ($data as $key => $user){
            $collection[] = new UserDTO(
                $user['id'],
                $user['first_name'],
                $user['last_name'],
                $user['age'],
                $user['email'],
                $user['phone_number']
            );
        }
        return $collection;
    }



    public function mapToArray(UserDtoCollection $collectionDTO): array
    {
        $collection = [];

        foreach ($collectionDTO as $key => $user)
        {
            $collection[] = [
                'id' => $user->id,
                'first_name' => $user->firstName,
                'last_mame' => $user->lastName,
                'age' => $user->age,
                'email' => $user->email,
                'phone_number' => $user->phoneNumber
                ];
        }
        return $collection;
    }

    public function MapToJson(UserDtoCollection $userDtoCollection): string
    {
        return json_encode($this->mapToArray($userDtoCollection), JSON_UNESCAPED_UNICODE);
    }
}