<?php

namespace App\Tests\InfrastructureLayer\User\DataMappers;

use App\InfrastructureLayer\Postgres\Entity\Address;
use App\InfrastructureLayer\Postgres\Entity\Profile;
use App\InfrastructureLayer\Postgres\Entity\Users;
use App\InfrastructureLayer\Postgres\User\DataMappers\UserEntityMapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UserEntityMapperTest extends TestCase
{
    /**
     * @dataProvider entitiesProvider
     */
    public function testMapToArray($usersEntities, $profilesEntities, $addressEntities)
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
                    'country' => $address->getCountry(),
                    'id' => $address->getId(),
                    'city' => $address->getCity(),
                    'street' => $address->getStreet(),
                    'house_number' => $address->getHouseNumber()
                ]
            ];
        }
        $actualResult = $users;

        $mapper = new UserEntityMapper();
        $expectedResult = $mapper->mapToArray($usersEntities, $profilesEntities, $addressEntities);

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function entitiesProvider(): array
    {
        return [
            'when data is valid' => [
                'usersEntities' => [
                    new Users(
                    '8d553526-9b22-11ee-a0d6-5db474521cf1',
                    'login',
                    '0000',
                    'email@mail.com',
                    '1234567890',
                    '8d375f60-9b22-11ee-a1da-5db474521cf1',
                    '8d4ef238-9b22-11ee-a1f2-5db474521cf1'
                ), new Users(
                        '4b82016a-9b22-11ee-aca0-53aa860577d5',
                        'login',
                        '0000',
                        'email@mail.com',
                        '1234567890',
                        '4b7b29e4-9b22-11ee-a969-53aa860577d5',
                        '4b818bf4-9b22-11ee-b054-53aa860577d5'
                    )
                ],
                'profilesEntities' => [
                    new Profile(
                    '8d4ef238-9b22-11ee-a1f2-5db474521cf1',
                    'name',
                    'lastname',
                    10,
                    null
                ), new Profile(
                        '4b818bf4-9b22-11ee-b054-53aa860577d5',
                        'name',
                        'lastname',
                        10,
                        null
                    )
                ],
                'addressEntities' => [
                    new Address(
                    '8d375f60-9b22-11ee-a1da-5db474521cf1',
                    'lapland',
                    'izumrudzk',
                    'pushkina',
                    'kolotushkina'
                ), new Address(
                        '4b7b29e4-9b22-11ee-a969-53aa860577d5',
                        'lapland',
                        'izumrudzk',
                        'pushkina',
                        'kolotushkina'
                    )
                ]
            ]
        ];
    }
}