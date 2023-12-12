<?php

namespace App\Tests\Domain\User\Factory;

use App\DomainLayer\User\Factory\UserFactory;
use App\DomainLayer\User\User;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use Composer\Semver\Constraint\Constraint;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactoryTest extends KernelTestCase
{
    /**
     * @dataProvider validUserFirstNameProvider
     */
    public function testWhenFirstNameIsValid($firstName): void
    {
        $createUserDTO = new CreateUserDTO(
            $firstName,
            'Petrov',
            12,
            'email@mail.com',
            null
        );

        $validatorMock = $this->createMock(ValidatorInterface::class);
        $validatorMock->expects($this->once())
            ->method('validate')
            ->with($createUserDTO)
            ->willReturn(new ConstraintViolationList());

        $userFactory = new UserFactory($validatorMock);

        $expectedResult = new User($createUserDTO);

        $user = $userFactory->createUser($createUserDTO);
        $actualResult = $user;

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
        $createUserDTO = new CreateUserDTO(
            'petr',
            $lastName,
            12,
            'email@mail.com',
            null
        );

        $validatorMock = $this->createMock(ValidatorInterface::class);
        $validatorMock->expects($this->once())
            ->method('validate')
            ->with($createUserDTO)
            ->willReturn(new ConstraintViolationList());

        $userFactory = new UserFactory($validatorMock);

        $expectedResult = new User($createUserDTO);

        $user = $userFactory->createUser($createUserDTO);
        $actualResult = $user;

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
}
