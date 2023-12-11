<?php

namespace App\Tests\InfrastructureLayer\DBManager;

use App\InfrastructureLayer\PostgresWithPDO\DBManagerWithPDO;
use App\InfrastructureLayer\UserDTO\DeleteUserDTO;
use App\InfrastructureLayer\UserDTO\EditUserDTO;
use App\InfrastructureLayer\UserDTO\GetUserDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DBManagerWithPDOTest extends KernelTestCase
{
    /**
     * @dataProvider saveUserProvider
     */
    public function testSaveUser($firstName, $lastName, $age, $email, $phoneNumber) : void
    {
        $dbManager = new DBManagerWithPDO();
        $savedUserDTO = $dbManager->saveUser(new SaveUserDTO(
            $firstName,
            $lastName,
            $age,
            $email,
            $phoneNumber
        ));

        $gotUserDTO = $dbManager->getUser(new GetUserDTO($savedUserDTO->id));

        $this->assertEquals(
            array(
                $firstName,
                $lastName,
                $age,
                $email,
                $phoneNumber
            ),
            array(
                $gotUserDTO->firstName,
                $gotUserDTO->lastName,
                $gotUserDTO->age,
                $gotUserDTO->email,
                $gotUserDTO->phoneNumber
            ));
        $dbManager->deleteUser(new DeleteUserDTO($savedUserDTO->id));
    }
    public function saveUserProvider(): array
    {
        return [
            'when user is valid' =>
                [
                    'firstName' => 'Dmitriy',
                    'lastName' => 'Rus',
                    'age' => 35,
                    'email' => 'v.mahoneko@mail.com',
                    'phoneNumber' => null
                ]
        ];
    }

    /**
     * @dataProvider getUserProvider
     */
    public function testGetUser($firstName, $lastName, $age, $email, $phoneNumber) : void
    {
        $dbManager = new DBManagerWithPDO();
        $savedUserDTO = $dbManager->saveUser(new SaveUserDTO(
            $firstName,
            $lastName,
            $age,
            $email,
            $phoneNumber
        ));

        $gotUserDTO = $dbManager->getUser(new GetUserDTO($savedUserDTO->id));

        $this->assertEquals(
            array(
                $firstName,
                $lastName,
                $age,
                $email,
                $phoneNumber
            ),
            array(
                $gotUserDTO->firstName,
                $gotUserDTO->lastName,
                $gotUserDTO->age,
                $gotUserDTO->email,
                $gotUserDTO->phoneNumber
            ));

        $dbManager->deleteUser(new DeleteUserDTO($savedUserDTO->id));
    }
    public function getUserProvider(): array
    {
        return [
            'when user is valid' =>
                [
                    'firstName' => 'Oleg',
                    'lastName' => 'Keinz',
                    'age' => 35,
                    'email' => 'v.mahoneko@mail.com',
                    'phoneNumber' => null
                ]
        ];
    }

    /**
     * @dataProvider editUserProvider
     */
    public function testEditUser($firstName, $lastName, $age, $email, $phoneNumber) : void
    {
        $dbManager = new DBManagerWithPDO();
        $savedUserDTO = $dbManager->saveUser(new SaveUserDTO(
            'old first name',
            'old last name',
            20,
            'old.email@mail.com',
            '88005553535'
        ));

        $dbManager->editUser(new EditUserDTO(
            $firstName,
            $lastName,
            $age,
            $email,
            $phoneNumber,
            $savedUserDTO->id));

        $gotUserDTO = $dbManager->getUser(new GetUserDTO($savedUserDTO->id));

        $this->assertEquals(
            array(
                $firstName,
                $lastName,
                $age,
                $email,
                $phoneNumber
            ),
            array(
                $gotUserDTO->firstName,
                $gotUserDTO->lastName,
                $gotUserDTO->age,
                $gotUserDTO->email,
                $gotUserDTO->phoneNumber
            ));
        $dbManager->deleteUser(new DeleteUserDTO($savedUserDTO->id));
    }
    public function editUserProvider(): array
    {
        return [
            'when user is valid' =>
                [
                    'newFirstName' => 'Filip',
                    'newLastName' => 'Kindred Dik',
                    'age' => 35,
                    'email' => 'v.mahoneko@mail.com',
                    'phoneNumber' => null
                ]
        ];
    }
}
