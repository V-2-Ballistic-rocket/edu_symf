<?php

namespace App\Tests;

use App\DomainLayer\User\CreateUserDTO;
use App\DomainLayer\User\UserFactory;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    /**
     * @dataProvider validUserFirstNameProvider
     */
    public function testWhenFirstNameIsValid($firstName): void
    {
        $expectedResult = array($firstName, 'Petrov');

        $user = UserFactory::createUser(new CreateUserDTO($firstName, 'Petrov'));
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
        $expectedResult = array('Petr', $lastName);

        $user = UserFactory::createUser(new CreateUserDTO('Petr', $lastName));
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
        $actualResult = UserFactory::createUser(new CreateUserDTO($firstName, 'Petrov'));

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
        $actualResult = UserFactory::createUser(new CreateUserDTO('Petr', $lastName));

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
