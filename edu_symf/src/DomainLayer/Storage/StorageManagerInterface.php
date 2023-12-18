<?php

namespace App\DomainLayer\Storage;

use App\DomainLayer\User\Registration\SavedUserDTO;
use App\DomainLayer\User\UserDTO\Collection\UserDtoCollection;
use App\DomainLayer\User\UserDTO\SaveUserDTO;

interface StorageManagerInterface
{
    public function saveUser(SaveUserDTO $saveUserDTO): SavedUserDTO;
    public function getUsers(): UserDtoCollection;

}