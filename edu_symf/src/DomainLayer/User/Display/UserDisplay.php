<?php

namespace App\DomainLayer\User\Display;

use App\DomainLayer\Storage\DTO\GetUserByIdDTO;
use App\DomainLayer\Storage\StorageManagerInterface;
use App\DomainLayer\User\Factory\UserFactory;
use App\DomainLayer\User\Registration\DataMappers\GotUserDtoMapper;
use App\DomainLayer\User\User;
use App\DomainLayer\User\UserDTO\Collection\UserCollectionDtoMapperInterface;
use Symfony\Component\Validator\Validation;

class UserDisplay
{
    public function __construct(
        private StorageManagerInterface          $storageManager,
        private UserCollectionDtoMapperInterface $userCollectionDtoMapper,
        private GotUserDtoMapper                 $gotUserDtoMapper
    )
    {}

    public function showUsers(): string
    {
        $userCollection = $this->storageManager->getUsers();
        return $this->userCollectionDtoMapper->mapToJson($userCollection);
    }

    public function getUserById(GetUserByIdDTO $getUserByIdDTO): User
    {
        $dto = $this->storageManager->getUserById($getUserByIdDTO);

        $userFactory = new UserFactory(Validation::createValidator());

        return $userFactory->createUser($this->gotUserDtoMapper->mapToCreateUserDTO($dto));
    }
}