<?php

namespace App\DomainLayer\Storage;

use App\DomainLayer\User\Registration\SavedUserDTO;
use App\DomainLayer\User\UserDTO\SaveUserDTO;
use App\InfrastructureLayer\User\DTO\GetUserDTO;
use App\InfrastructureLayer\User\DTO\GotUserDTO;

interface StorageManagerInterface
{
    public function saveUser(SaveUserDTO $saveUserDTO) : SavedUserDTO;
    public function getUser(GetUserDTO $getUserDTO) : GotUserDTO;

}