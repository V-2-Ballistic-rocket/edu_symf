<?php

namespace App\DomainLayer\Storage;

use App\DomainLayer\User\UserDTO\SaveUserDTO;
use App\InfrastructureLayer\User\DTO\GetUserDTO;
use App\InfrastructureLayer\User\DTO\GotUserDTO;
use App\InfrastructureLayer\User\DTO\SavedUserDTO;

interface StorageManagerInterface
{
    public function saveUser(SaveUserDTO $saveUserDTO) : SavedUserDTO;
    public function getUser(GetUserDTO $getUserDTO) : GotUserDTO;

}