<?php

namespace App\Tests;

use App\DomainLayer\User\Factory\UserFactory;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserFactoryTest extends KernelTestCase
{
    /**
     * @dataProvider validUserFirstNameProvider
     */
    public function testWhenFirstNameIsValid($firstName): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $userFactory = $container->get(UserFactory::class);

        $expectedResult = array(
            $firstName,
            'Petrov',
            12,
            'email@mail.com',
            null
        );

        $user = $userFactory->createUser(new CreateUserDTO(
            $firstName,
            'Petrov',
            12,
            'email@mail.com',
            null
        ));
        $actualResult = array(
            $user->getFirstName(),
            $user->getLastName(),
            $user->getAge(),
            $user->getEmail(),
            $user->getPhoneNumber()
        );

        $this->assertEquals($expectedResult, $actualResult);
    }
    public function validUserFirstNameProvider():array
    {
        return [
            'when first name is valid' => [
                'Petr'
            ]
        ];
    }

    /**
     * @dataProvider validUserLastNameProvider
     */
    public function testWhenLastNameIsValid($lastName): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $expectedResult = array(
            'Petr',
            $lastName,
            12,
            'email@mail.com',
            '88005553535'
        );
        $userFactory = $container->get(UserFactory::class);
        $user = $userFactory->createUser(new CreateUserDTO(
            'Petr',
            $lastName,
            12,
            'email@mail.com',
            '88005553535'
        ));
        $actualResult = array(
            $user->getFirstName(),
            $user->getLastName(),
            $user->getAge(),
            $user->getEmail(),
            $user->getPhoneNumber()
        );

        $this->assertEquals($expectedResult, $actualResult);
    }
    public function validUserLastNameProvider():array
    {
        return [
            'when last name is valid' => [
                'Petrov'
            ]
        ];
    }

    /**
     * @dataProvider invalidFirstNameProvider
     */
    public function testWhereFirstNameInvalid($firstName): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $userFactory = $container->get(UserFactory::class);

        $actualResult = $userFactory->createUser(new CreateUserDTO(
            $firstName,
            'Petrov',
            12,
            'email@mail.com',
            null
        ));

        $this->assertNull($actualResult);
    }
    public function invalidFirstNameProvider():array
    {
        return [
            'when first name is blank' => [
                ''
            ]
        ];
    }

    /**
     * @dataProvider invalidFirstNameProvider
     */
    public function testWhereLastNameInvalid($lastName): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $userFactory = $container->get(UserFactory::class);

        $actualResult = $userFactory->createUser(new CreateUserDTO(
            'name',
            $lastName,
            12,
            'email@mail.com',
            null
        ));

        $this->assertNull($actualResult);
    }
    public function invalidLastNameProvider():array
    {
        return [
            'when last name is blank' => [
                ''
            ]
        ];
    }
}
