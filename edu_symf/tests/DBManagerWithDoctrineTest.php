<?php

namespace App\Tests;

use App\InfrastructureLayer\PostgresWithDoctrine\DBManagerWithDoctrine;
use App\InfrastructureLayer\PostgresWithPDO\DBManagerWithPDO;
use App\InfrastructureLayer\UserDTO\DeleteUserDTO;
use App\InfrastructureLayer\UserDTO\GetUserDTO;
use App\InfrastructureLayer\UserDTO\SavedUserDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class DBManagerWithDoctrineTest extends KernelTestCase
{
    /**
     *@dataProvider saveUserProvider
     */
    public function testSaveUser($firstName, $lastName, $age, $email, $phoneNumber): void
    {
        $saveUserDTO = new SaveUserDTO(
            $firstName,
            $lastName,
            $age,
            $email,
            $phoneNumber
        );

        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $managerRegistry->method('getManagerForClass')->willReturn($entityManager);

        $entityManager->expects($this->once())
            ->method('persist');
        $entityManager->expects($this->once())
            ->method('flush');

        $dbManager = new DBManagerWithDoctrine($managerRegistry);

        $savedUserDTO = $dbManager->saveUser($saveUserDTO);
        $this->assertInstanceOf(SavedUserDTO::class, $savedUserDTO);
    }

    public function saveUserProvider() : array
    {
        return [
            'when valid data' =>
            [
                'firstName' => 'Vasiliy',
                'lastName' => 'Mahonenko',
                'age' => 35,
                'email' => 'v.mahoneko@mail.com',
                'phoneNumber' => null
            ]
        ];
    }

    /**
     * @dataProvider getUserProvider
     */
    public function testGetUserPDO($firstName, $lastName, $age, $email, $phoneNumber) : void
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
            )
        );
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
}
