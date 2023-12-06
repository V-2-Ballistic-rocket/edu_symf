<?php

namespace App\DomainLayer;

use App\InfrastructureLayer\UserDTO\DeleteUserDTO;
use App\InfrastructureLayer\UserDTO\EditUserDTO;
use App\InfrastructureLayer\UserDTO\GetUserDTO;
use App\InfrastructureLayer\UserDTO\GotUserDTO;
use App\InfrastructureLayer\UserDTO\SavedUserDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;

interface StorageManagerInterface
{
    public function saveUser(SaveUserDTO $saveUserDTO) : SavedUserDTO;
    public function getUser(GetUserDTO $getUserDTO) : GotUserDTO;
    public function deleteUser(DeleteUserDTO $deleteUserDTO) : void;
    public function editUser(EditUserDTO $editUserDTO) : void;
}