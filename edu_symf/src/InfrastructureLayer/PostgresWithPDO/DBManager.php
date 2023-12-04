<?php

namespace App\InfrastructureLayer\PostgresWithPDO;

use App\InfrastructureLayer\StorageManagerInterface;
use App\InfrastructureLayer\UserDTO\DeleteUserDTO;
use App\InfrastructureLayer\UserDTO\EditUserDTO;
use App\InfrastructureLayer\UserDTO\GetUserDTO;
use App\InfrastructureLayer\UserDTO\GotUserDTO;
use App\InfrastructureLayer\UserDTO\SavedUserDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use PDO;

class DBManager implements StorageManagerInterface
{
    //private string $queryGetUser = "SELECT firstName, lastName FROM users WHERE user_id = {$id};";


    private string $toSqlFilePath = './src/InfrastructureLayer/PostgresWithPDO/init.sql';
    private string $connectionParams = 'pgsql:host=172.19.160.1;dbname=app2';
    private string $user = 'postgres';
    private string $password = 'postgres';
    private function initDB()
    {
        $DBH = new PDO($this->connectionParams, $this->user, $this->password);
        $DBH->exec(file_get_contents($this->toSqlFilePath));

        return $DBH;
    }

    public function saveUser(SaveUserDTO $saveUserDTO) : SavedUserDTO
    {
        $DBH = $this->initDB();
        $DBH->query("INSERT INTO users (firstName, lastName)
        VALUES ('{$saveUserDTO->firstName}', '{$saveUserDTO->lastName}');");

        return new SavedUserDTO($DBH->lastInsertId());
    }

    public function getUser(GetUserDTO $getUserDTO) : GotUserDTO
    {
        $DBH = $this->initDB();
        $result = $DBH->query("SELECT firstname, lastname FROM users WHERE user_id = {$getUserDTO->id};")
            ->fetch(PDO::PARAM_STR);
        return new GotUserDTO($result['firstname'], $result['lastname']);
    }

    public function deleteUser(DeleteUserDTO  $deleteUserDTO) : void
    {
        $this->initDB()->query("DELETE FROM users WHERE user_id = {$deleteUserDTO->id}");
    }

    public function editUser(EditUserDTO $editUserDTO) : void
    {
        $DBH = $this->initDB();
        $result = $DBH->query(
            "UPDATE product
            SET firstname = '{$editUserDTO->firstName}', lastname = '{$editUserDTO->lastName}'
            WHERE product_id = {$editUserDTO->id}"
        );
    }
}