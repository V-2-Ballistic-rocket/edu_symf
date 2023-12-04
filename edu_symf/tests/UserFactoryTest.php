<?php

namespace App\Tests;

use App\DomainLayer\Factory\UserFactory;
use App\DomainLayer\UserDTO\CreateUserDTO;
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

        $expectedResult = array($firstName, 'Petrov');

        $user = $userFactory->createUser(new CreateUserDTO($firstName, 'Petrov'));
        $actualResult = array($user->getFirstName(), $user->getLastName());

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

        $expectedResult = array('Petr', $lastName);
        $userFactory = $container->get(UserFactory::class);
        $user = $userFactory->createUser(new CreateUserDTO('Petr', $lastName));
        $actualResult = array($user->getFirstName(), $user->getLastName());

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

        $actualResult = $userFactory->createUser(new CreateUserDTO($firstName, 'Petrov'));

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

        $actualResult = $userFactory->createUser(new CreateUserDTO('Petr', $lastName));

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
