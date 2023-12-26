<?php

namespace App\DomainLayer\Storage;

use App\DomainLayer\User\Registration\DTO\GetUserByTokenDTO;
use App\DomainLayer\User\Registration\DTO\GotUserDTO;
use App\DomainLayer\User\Registration\DTO\SavedUserDTO;
use App\DomainLayer\User\UserDTO\Collection\UserDtoCollection;
use App\DomainLayer\User\UserDTO\SaveUserDTO;

interface StorageManagerInterface
{
    public function saveUser(SaveUserDTO $saveUserDTO): SavedUserDTO;
    public function getUsers(): UserDtoCollection;

    public function getUserByToken(GetUserByTokenDTO $getUserByTokenDTO): GotUserDTO;

}