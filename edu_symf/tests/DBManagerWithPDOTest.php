<?php

namespace App\Tests;

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
    public function testSaveUser($firstName, $lastName) : void
    {
        $dbManager = new DBManagerWithPDO();
        $savedUserDTO = $dbManager->saveUser(new SaveUserDTO($firstName, $lastName));

        $gotUserDTO = $dbManager->getUser(new GetUserDTO($savedUserDTO->id));

        $this->assertEquals(array($firstName, $lastName), array($gotUserDTO->firstName, $gotUserDTO->lastName));

        $dbManager->deleteUser(new DeleteUserDTO($savedUserDTO->id));
    }
    public function saveUserProvider(): array
    {
        return [
            'when user is valid' =>
            [
                'firstName' => 'Dmitriy',
                'lastName' => 'Rus'
            ]
        ];
    }

    /**
     * @dataProvider getUserProvider
     */
    public function testGetUser($firstName, $lastName) : void
    {
        $dbManager = new DBManagerWithPDO();
        $savedUserDTO = $dbManager->saveUser(new SaveUserDTO($firstName, $lastName));

        $gotUserDTO = $dbManager->getUser(new GetUserDTO($savedUserDTO->id));

        $this->assertEquals(
            array($firstName, $lastName),
            array($gotUserDTO->firstName, $gotUserDTO->lastName)
        );
        $dbManager->deleteUser(new DeleteUserDTO($savedUserDTO->id));
    }
    public function getUserProvider(): array
    {
        return [
            'when user is valid' =>
            [
                'firstName' => 'Oleg',
                'lastName' => 'Keinz'
            ]
        ];
    }

    /**
     * @dataProvider editUserProvider
     */
    public function testEditUser($newFirstName, $newLastName) : void
    {
        $dbManager = new DBManagerWithPDO();
        $savedUserDTO = $dbManager->saveUser(new SaveUserDTO('old first name', 'old last name'));

        $dbManager->editUser(new EditUserDTO($newFirstName, $newLastName, $savedUserDTO->id));

        $gotUserDTO = $dbManager->getUser(new GetUserDTO($savedUserDTO->id));

        $this->assertEquals(
            array($newFirstName, $newLastName),
            array($gotUserDTO->firstName, $gotUserDTO->lastName)
        );
        $dbManager->deleteUser(new DeleteUserDTO($savedUserDTO->id));
    }
    public function editUserProvider(): array
    {
        return [
            'when user is valid' =>
            [
                'newFirstName' => 'Filip',
                'newLastName' => 'Kindred Dik'
            ]
        ];
    }
}
