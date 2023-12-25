<?php

namespace App\Tests\InfrastructureLayer\User\DataMappers;

use App\DomainLayer\Address\AddressDTO\AddressDTO;
use App\DomainLayer\User\Profile\DTO\ProfileDTO;
use App\DomainLayer\User\UserDTO\Collection\UserDTO;
use App\DomainLayer\User\UserDTO\Collection\UserDtoCollection;
use App\InfrastructureLayer\Postgres\User\DataMappers\UserCollectionMapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UserCollectionMapperTest extends TestCase
{
    /**
     * @dataProvider arrayProvider
     */
    public function testMapFromArray(array $data)
    {
        $collection = new UserDtoCollection();
        foreach ($data as $key => $user) {
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
        $expectedResult = $collection;
        $mapper = new UserCollectionMapper();
        $actualResult = $mapper->mapFromArray($data);
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function arrayProvider(): array
    {
        return [
            [
                [array(
                    'id' => Uuid::v1(),
                    'login' => 'login1',
                    'password' => 'password1',
                    'email' => 'email@email.com',
                    'phone_number' => '1233456789',
                    'profile' =>
                        [
                            'id' => Uuid::v1(),
                            'first_name' => 'first name',
                            'last_name' => 'last name',
                            'age' => 32,
                            'to_avatar_path' => 'to avatar path'
                        ],
                    'address' =>
                        [
                            'id' => Uuid::v1(),
                            'country' => 'lapland',
                            'city' => 'New Down City',
                            'street' => 'Pushkina',
                            'house_number' => 'Kolotushkina'
                        ]
                ), array(
                    'id' => Uuid::v1(),
                    'login' => 'login2',
                    'password' => 'password2',
                    'email' => 'email2@email.com',
                    'phone_number' => '1233456789',
                    'profile' =>
                        [
                            'id' => Uuid::v1(),
                            'first_name' => 'first name',
                            'last_name' => 'last name',
                            'age' => 32,
                            'to_avatar_path' => 'to avatar path'
                        ],
                    'address' =>
                        [
                            'id' => Uuid::v1(),
                            'country' => 'lapland',
                            'city' => 'New Down City',
                            'street' => 'Pushkina',
                            'house_number' => 'Kolotushkina'
                        ]
                ), array(
                    'id' => Uuid::v1(),
                    'login' => 'login3',
                    'password' => 'password3',
                    'email' => 'email3@email.com',
                    'phone_number' => '1233456789',
                    'profile' =>
                        [
                            'id' => Uuid::v1(),
                            'first_name' => 'first name',
                            'last_name' => 'last name',
                            'age' => 32,
                            'to_avatar_path' => 'to avatar path'
                        ],
                    'address' =>
                        [
                            'id' => Uuid::v1(),
                            'country' => 'lapland',
                            'city' => 'New Down City',
                            'street' => 'Pushkina',
                            'house_number' => 'Kolotushkina'
                        ]
                    )
                ]
            ]
        ];
    }

    /**
     * @dataProvider collectionProvider
     */
    public function testMapToArray($userDtoCollection)
    {
        $collection = [];
        foreach ($userDtoCollection as $key => $user) {
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
        $expectedResult = $collection;
        $mapper = new UserCollectionMapper();
        $actualResult = $mapper->mapToArray($userDtoCollection);

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function collectionProvider(): array
    {
        return [
            [
                new UserDtoCollection(
                    new UserDTO(
                        Uuid::v1(),
                        'login',
                        'password',
                        'email@email.com',
                        'phone_number',
                        new ProfileDTO(
                            Uuid::v1(),
                            'profile_first_name',
                            'profile_last_name',
                            14,
                            'profile_to_avatar_path'
                        ),
                        new AddressDTO(
                            'address_id',
                            'address_country',
                            'address_city',
                            'address_street',
                            'address_house_number'
                        )
                    ), new UserDTO(
                    Uuid::v1(),
                    'login',
                    'password',
                    'email@email.com',
                    'phone_number',
                    new ProfileDTO(
                        Uuid::v1(),
                        'profile_first_name',
                        'profile_last_name',
                        35,
                        'profile_to_avatar_path'
                    ),
                    new AddressDTO(
                        'address_id',
                        'address_country',
                        'address_city',
                        'address_street',
                        'address_house_number'
                    )
                ), new UserDTO(
                        Uuid::v1(),
                        'login3',
                        'password3',
                        'email3@email.com',
                        'phone_number3',
                        new ProfileDTO(
                            Uuid::v1(),
                            'profile_first_name3',
                            'profile_last_name3',
                            86,
                            'profile_to_avatar_path3'
                        ),
                        new AddressDTO(
                            'address_id3',
                            'address_country3',
                            'address_city3',
                            'address_street3',
                            'address_house_number3'
                        )
                    )
                )
            ]
        ];
    }

    /**
     * @dataProvider collectionToJsonProvider
     */
    public function testMapToJson($userDtoCollection)
    {
        $collection = [];
        foreach ($userDtoCollection as $key => $user) {
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
        $mapper = new UserCollectionMapper();
        $expectedResult = json_encode($collection, JSON_UNESCAPED_UNICODE);
        $actualResult = $mapper->MapToJson($userDtoCollection);

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function collectionToJsonProvider(): array
    {
        return [
            [
                new UserDtoCollection(
                    new UserDTO(
                        Uuid::v1(),
                        'login',
                        'password',
                        'email@email.com',
                        'phone_number',
                        new ProfileDTO(
                            Uuid::v1(),
                            'profile_first_name',
                            'profile_last_name',
                            14,
                            'profile_to_avatar_path'
                        ),
                        new AddressDTO(
                            'address_id',
                            'address_country',
                            'address_city',
                            'address_street',
                            'address_house_number'
                        )
                    ), new UserDTO(
                    Uuid::v1(),
                    'login',
                    'password',
                    'email@email.com',
                    'phone_number',
                    new ProfileDTO(
                        Uuid::v1(),
                        'profile_first_name',
                        'profile_last_name',
                        35,
                        'profile_to_avatar_path'
                    ),
                    new AddressDTO(
                        'address_id',
                        'address_country',
                        'address_city',
                        'address_street',
                        'address_house_number'
                    )
                ), new UserDTO(
                        Uuid::v1(),
                        'login3',
                        'password3',
                        'email3@email.com',
                        'phone_number3',
                        new ProfileDTO(
                            Uuid::v1(),
                            'profile_first_name3',
                            'profile_last_name3',
                            86,
                            'profile_to_avatar_path3'
                        ),
                        new AddressDTO(
                            'address_id3',
                            'address_country3',
                            'address_city3',
                            'address_street3',
                            'address_house_number3'
                        )
                    )
                )
            ]
        ];
    }
}