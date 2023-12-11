<?php

namespace App\Tests\Domain\User\Registration;

use App\DomainLayer\User\Registration\UserRegistration;
use App\DomainLayer\User\UserDTO\UserRegistrationDTO;
use App\InfrastructureLayer\PostgresWithDoctrine\DBManagerWithDoctrine;
use App\InfrastructureLayer\UserDTO\SavedUserDTO;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRegistrationTest extends KernelTestCase
{
    /**
     * @dataProvider validUserRegistrationTestMethodProvider
     */
    public function testUserRegistrationMethod($firstName, $lastName, $age, $email, $phoneNumber): void
    {
        $userRegistration = $this->createMock(UserRegistration::class);
        $storageManager = $this->createMock(DBManagerWithDoctrine::class);

        $savedUserDTO = $userRegistration->registrationUser(new UserRegistrationDTO(
            $firstName,
            $lastName,
            $age,
            $email,
            $phoneNumber), $storageManager);

        $this->assertInstanceOf(SavedUserDTO::class, $savedUserDTO);
    }
    public function validUserRegistrationTestMethodProvider(): array
    {
        return [
            'when user is valid' =>
                [
                    'firstName' => 'Alexandr',
                    'lastName' => 'Ivanov',
                    'age' => 35,
                    'email' => 'a.ivanov@mail.com',
                    'phoneNumber' => null
                ]
        ];
    }
}
