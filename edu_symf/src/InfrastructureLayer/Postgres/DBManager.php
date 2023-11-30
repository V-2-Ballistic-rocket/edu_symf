<?php

namespace App\InfrastructureLayer\Postgres;

use PDO;

class DBManager
{
    private string $toSqlFilePath = '../Postgres/init.sql';
    private string $connectionParams = 'pgsql:host=postgres;dbname=app2';
    private string $user = 'postgres';
    private string $password = 'postgres';
    private function initDB(){
        $DBH = new PDO($this->connectionParams, $this->user, $this->password);
        $DBH->exec(file_get_contents($this->toSqlFilePath));

        return $DBH;
    }

    public function saveUser(SaveUserDTO $saveUserDTO) : int
    {
        $DBH = $this->initDB();
        $DBH->query("INSERT INTO users (firstName, lastName)
        VALUES ('{$saveUserDTO->firstName}', '{$saveUserDTO->lastName}';");

        return $DBH->lastInsertId();
    }

    public function getUser(int $id) : UserDTO
    {
        $DBH = $this->initDB();
        $DBH->query("INSERT INTO users (firstName, lastName)
        VALUES ('{$saveUserDTO->firstName}', '{$saveUserDTO->lastName}';");

        return $DBH->lastInsertId();
    }
}