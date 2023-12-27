<?php

namespace App\DomainLayer\User\Display;

use App\DomainLayer\Storage\StorageManagerInterface;
use App\DomainLayer\User\UserDTO\Collection\UserCollectionDtoMapperInterface;

class UserDisplay
{
    public function __construct(
        private StorageManagerInterface $storageManager,
        private UserCollectionDtoMapperInterface $mapper
    )
    {}

    public function showUsers(): string
    {
        $userCollection = $this->storageManager->getUsers();
        return $this->mapper->mapToJson($userCollection);
    }
}