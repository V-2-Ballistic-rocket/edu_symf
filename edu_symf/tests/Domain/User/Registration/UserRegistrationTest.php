<?php

namespace App\Tests\Domain\User\Registration;

use App\DomainLayer\Storage\StorageManagerInterface;
use App\DomainLayer\User\Registration\DTO\SavedUserDTO;
use App\DomainLayer\User\Registration\DTO\UserRegistrationDTO;
use App\DomainLayer\User\Registration\UserRegistration;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRegistrationTest extends KernelTestCase
{
    /**
     * @dataProvider userRegistrationProvider
     */
    public function testRegistration($userRegistrationDTO)
    {
        $expectedResult = new SavedUserDTO('qwerty-qwerty-123456-123456');
        $storageManager = $this->createMock(StorageManagerInterface::class);
        $storageManager->expects($this->once())
            ->method('saveUser')
            ->willReturn($expectedResult);
        $register = new UserRegistration();
        $actualResult = $register->registrationUser($userRegistrationDTO, $storageManager);
        $expectedResult = new SavedUserDTO('qwerty-qwerty-123456-123456');
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function userRegistrationProvider(): array
    {
        return [
            [
                'userRegistrationDTO' => new UserRegistrationDTO(
                    'login',
                    'password',
                    'email@email.com',
                    '88005553535',
                    'anton',
                    'teryentyev',
                    14,
                    '',
                    'Lapland',
                    'Mega City',
                    'Hard street',
                    '123C',
                    'qwerty-qwerty-123456-123456'
                )
            ]
        ];
    }
}