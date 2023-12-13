<?php

namespace App\InfrastructureLayer\UserDTO\DataMappers;

use Symfony\Component\Uid\Uuid;

class UserEntityMapper
{
    public function mapToArray(array $userDtoCollection): array
    {
        $users = [];
        foreach ($userDtoCollection as $user){
            $users[] = [
                'id' => Uuid::fromString($user->getId()),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'age' => $user->getAge(),
                'email' => $user->getEmail(),
                'phone_number' => $user->getPhoneNumber()
            ];
        }
        return $users;
    }
}