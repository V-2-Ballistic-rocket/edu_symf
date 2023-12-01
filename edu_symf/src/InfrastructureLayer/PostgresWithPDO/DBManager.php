<?php

namespace App\InfrastructureLayer\PostgresWithPDO;

use App\InfrastructureLayer\EditUserDTO;
use App\InfrastructureLayer\GotUserDTO;
use App\InfrastructureLayer\SaveUserDTO;
use PDO;

class DBManager
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

    public function saveUser(SaveUserDTO $saveUserDTO) : int
    {
        $DBH = $this->initDB();
        $DBH->query("INSERT INTO users (firstName, lastName)
        VALUES ('{$saveUserDTO->firstName}', '{$saveUserDTO->lastName}');");

        return $DBH->lastInsertId();
    }

    public function getUser(int $id) : GotUserDTO
    {
        $DBH = $this->initDB();
        $result = $DBH->query("SELECT firstname, lastname FROM users WHERE user_id = {$id};")
            ->fetch(PDO::PARAM_STR);
        return new GotUserDTO($result['firstname'], $result['lastname']);
    }

    public function deleteUser(int $id) : void
    {
        $this->initDB()->query("DELETE FROM users WHERE user_id = {$id}");
    }

    public function editUser(EditUserDTO $editUserDTO)
    {
        $DBH = $this->initDB();
        $result = $DBH->query(
            "UPDATE product
            SET firstname = '{$editUserDTO->firstname}', lastname = '{$editUserDTO->lastname}'
            WHERE product_id = {$editUserDTO->id}"
        );
    }
}