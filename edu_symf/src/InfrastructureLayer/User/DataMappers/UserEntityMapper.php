<?php

namespace App\InfrastructureLayer\User\DataMappers;

use Symfony\Component\Uid\Uuid;

class UserEntityMapper
{
    public function mapToArray(array $usersEntities , array $profilesEntities, array $addressEntities): array
    {
        $users = [];
        foreach ($usersEntities  as $user){
            $address = null;
            $profile = null;
            foreach ($addressEntities as $addressFromArray)
            {
                if($user->getAddressId() == $addressFromArray->getId())
                {
                    $address = $addressFromArray;
                    break;
                }
            }
            foreach ($profilesEntities as $profileFromArray)
            {
                if($user->getProfileId() == $profileFromArray->getId())
                {
                    $profile = $profileFromArray;
                    break;
                }
            }
            $users[] = [
                'id' => Uuid::fromString($user->getId()),
                'login' => $user->getLogin(),
                'password' => $user->getPassword(),
                'email' => $user->getEmail(),
                'phone_number' => $user->getPhoneNumber(),
                'profile' => [
                    'id' => $profile->getId(),
                    'first_name' => $profile->getFirstName(),
                    'last_name' => $profile->getLastName(),
                    'age' => $profile->getAge(),
                    'to_avatar_path' => $profile->getToAvatarPath()
                ],
                'address' => [
                    'id' => $address->getId(),
                    'country' => $address->getCountry(),
                    'city' => $address->getCity(),
                    'street' => $address->getStreet(),
                    'house_number' => $address->getHouseNumber()
                ]
            ];
        }
        return $users;
    }
}