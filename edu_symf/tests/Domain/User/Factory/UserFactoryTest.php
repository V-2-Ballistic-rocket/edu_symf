<?php

namespace App\Tests\Domain\User\Factory;

use App\DomainLayer\Address\Address;
use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use App\DomainLayer\User\Factory\UserFactory;
use App\DomainLayer\User\Profile\Avatar\Avatar;
use App\DomainLayer\User\Profile\DTO\CreateProfileDTO;
use App\DomainLayer\User\Profile\Profile;
use App\DomainLayer\User\User;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactoryTest extends TestCase
{
    /**
     * @dataProvider createUserProvider
     */
    public function testCreateUser($createUserDTO)
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->exactly(3))
            ->method('validate');
        $factory = new UserFactory($validator);
        $actualResult = $factory->createUser($createUserDTO);

        $expectedResult = new User(
            $createUserDTO->id,
            $createUserDTO->login,
            $createUserDTO->password,
            $createUserDTO->email,
            $createUserDTO->phoneNumber,
            new Profile(
                $createUserDTO->createProfileDTO->firstName,
                $createUserDTO->createProfileDTO->lastName,
                $createUserDTO->createProfileDTO->age,
                new Avatar($createUserDTO->createProfileDTO->toAvatarPath)
            ),
            new Address( $createUserDTO->createAddressDTO)
        );
        $this->assertEquals($expectedResult, $actualResult);
    }
    public function createUserProvider(): array
    {
        return [
            [
                new CreateUserDTO(
                    'login',
                    'password',
                    'email@email.com',
                    '+78805553535',
                    new CreateProfileDTO(
                        'anton',
                        'pavlovich teryentyev',
                        14,
                        ''
                    ),
                    new CreateAddressDTO(
                        'Lapland',
                        'Lego City',
                        'Lego street',
                        '123/4B'
                    ),
                    '1234-5678-9101'
                )
            ]
        ];
    }
}
