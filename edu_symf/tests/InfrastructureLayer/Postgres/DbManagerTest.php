<?php

namespace App\Tests\InfrastructureLayer\Postgres;

use App\DomainLayer\Address\AddressDTO\SaveAddressDTO;
use App\DomainLayer\User\Profile\Avatar\Avatar;
use App\DomainLayer\User\Profile\DTO\SaveProfileDTO;
use App\DomainLayer\User\Registration\DTO\SavedUserDTO;
use App\DomainLayer\User\UserDTO\Collection\UserDtoCollection;
use App\DomainLayer\User\UserDTO\SaveUserDTO;
use App\InfrastructureLayer\Postgres\DbManager;
use App\InfrastructureLayer\Repository\UsersRepository;
use App\InfrastructureLayer\User\DataMappers\UserCollectionMapper;
use App\InfrastructureLayer\User\DataMappers\UserEntityMapper;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;


class DbManagerTest extends KernelTestCase
{

    public function testGetUsers()
    {
        $entityManager = $this->createMock(ManagerRegistry::class);
        $userRepository = $this->createMock(UsersRepository::class);
        $entityMapper = $this->createMock(UserEntityMapper::class);
        $collectionMapper = $this->createMock(UserCollectionMapper::class);

        $users = [];
        $address = [];
        $profiles = [];
        $data = [];
        $userDtoCollection = new UserDtoCollection();

        $entityManager->expects($this->once())
            ->method('getManagerForClass')
            ->willReturn($entityManager);

        $entityManager->expects($this->exactly(3))
            ->method('getRepository')
            ->willReturn($userRepository);

        $userRepository->expects($this->exactly(3))
            ->method('findAll')
            ->willReturn($users);

        $entityMapper->expects($this->once())
            ->method('mapToArray')
            ->with($users, $profiles, $address)
            ->willReturn($data);

        $collectionMapper->expects($this->once())
            ->method('mapFromArray')
            ->with($data)
            ->willReturn($userDtoCollection);

        $userService = new DbManager($entityManager, $collectionMapper, $entityMapper);
        $result = $userService->getUsers();

        $this->assertInstanceOf(UserDtoCollection::class, $result);
    }



    /**
     * @dataProvider provideSaveUserDTO
     */
    public function testSaveUser($saveUserDto)
    {
        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $entityManager = $this->createMock(EntityManager::class);
        $collectionMapper = $this->createMock(UserCollectionMapper::class);
        $entityMapper = $this->createMock(UserEntityMapper::class);

        $managerRegistry->expects($this->exactly(3))
            ->method('getManagerForClass')
            ->willReturn($entityManager);
        $entityManager->expects($this->exactly(3))
            ->method('persist');
        $entityManager->expects($this->exactly(3))
            ->method('flush');
        $dbManager = new DbManager($managerRegistry, $collectionMapper, $entityMapper);
        $result = $dbManager->saveUser($saveUserDto);
        $this->assertInstanceOf(SavedUserDTO::class, $result);
    }
    public function provideSaveUserDTO(): array
    {
        return [
            [
                new SaveUserDTO(
                    'login',
                    'password',
                    'email',
                    'phone number',
                    new SaveProfileDTO(
                        'first name',
                        'last name',
                        22,
                        new Avatar('to avatar path')
                    ),
                    new SaveAddressDTO(
                        'country',
                        'city',
                        'street',
                        'phone number'
                    )
                )
            ]
        ];
    }

    /**
     * @dataProvider provideSaveProfileDTO
     */
    public function testSaveProfile($saveProfileDTO): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $entityManager = $this->createMock(EntityManager::class);
        $collectionMapper = $this->createMock(UserCollectionMapper::class);
        $entityMapper = $this->createMock(UserEntityMapper::class);

        $registry->expects($this->once())
            ->method('getManagerForClass')
            ->willReturn($entityManager);
        $entityManager->expects($this->once())
            ->method('persist');
        $entityManager->expects($this->once())
            ->method('flush');

        $dbManager = new DbManager($registry, $collectionMapper, $entityMapper);
        $result = $dbManager->saveProfile($saveProfileDTO);

        $this->assertInstanceOf(Uuid::class, $result);
    }
    public function provideSaveProfileDTO(): array
    {
        return [
            [
                new SaveProfileDTO(
                    'first name',
                    'last name',
                    29,
                    new Avatar('path to file')
                )
            ]
        ];
    }

    /**
     * @dataProvider provideSaveAddressDTO
     */
    public function testSaveAddress($saveAddressDTO): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $entityManager = $this->createMock(EntityManager::class);
        $collectionMapper = $this->createMock(UserCollectionMapper::class);
        $entityMapper = $this->createMock(UserEntityMapper::class);

        $registry->expects($this->once())
            ->method('getManagerForClass')
            ->willReturn($entityManager);
        $entityManager->expects($this->once())
            ->method('persist');
        $entityManager->expects($this->once())
            ->method('flush');

        $dbManager = new DbManager($registry, $collectionMapper, $entityMapper);
        $result = $dbManager->saveAddress($saveAddressDTO);

        $this->assertInstanceOf(Uuid::class, $result);
    }
    public function provideSaveAddressDTO(): array
    {
        return [
            [
                new SaveAddressDTO(
                    'country',
                    'city',
                    'street',
                    'house number'
                )
            ]
        ];
    }
}
