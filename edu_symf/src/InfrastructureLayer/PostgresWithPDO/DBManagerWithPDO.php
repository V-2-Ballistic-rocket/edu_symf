<?php

namespace App\InfrastructureLayer\PostgresWithPDO;

use App\DomainLayer\StorageManagerInterface;
use App\InfrastructureLayer\UserDTO\DeleteUserDTO;
use App\InfrastructureLayer\UserDTO\EditUserDTO;
use App\InfrastructureLayer\UserDTO\GetUserDTO;
use App\InfrastructureLayer\UserDTO\GotUserDTO;
use App\InfrastructureLayer\UserDTO\SavedUserDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use PDO;
use Symfony\Component\Uid\Uuid;

class DBManagerWithPDO implements StorageManagerInterface
{
    //private string $queryGetUser = "SELECT firstName, lastName FROM users WHERE user_id = {$id};";


    private string $toSqlFilePath = './src/InfrastructureLayer/PostgresWithPDO/init.sql';
    private string $connectionParams = 'pgsql:host=172.19.160.1;dbname=app';
    private string $user = 'postgres';
    private string $password = 'postgres';
    private function initDB()
    {

        //$DBH->exec(file_get_contents($this->toSqlFilePath));

        return $DBH = new PDO($this->connectionParams, $this->user, $this->password);
    }

    public function saveUser(SaveUserDTO $saveUserDTO) : SavedUserDTO
    {
        $DBH = $this->initDB();
        $sth = $DBH->prepare("INSERT INTO users (id, firstName, lastName)
        VALUES (:id, :firstname, :lastname);");
        $id = Uuid::v1();
        $sth->execute(['id' => $id, 'firstname' => $saveUserDTO->firstName, 'lastname' => $saveUserDTO->lastName]);
        return new SavedUserDTO($id);
    }

    public function getUser(GetUserDTO $getUserDTO) : GotUserDTO
    {
        if(!$getUserDTO->id){
            throw new \Exception('Пользователь не найден', 404);
        }
        $DBH = $this->initDB();
        $sth = $DBH->prepare("SELECT firstname, lastname FROM users WHERE id = :id;");
        $sth->execute(['id' => $getUserDTO->id]);
        $result = $sth->fetch(PDO::PARAM_STR);

        return new GotUserDTO($result['firstname'], $result['lastname']);
    }

    public function deleteUser(DeleteUserDTO  $deleteUserDTO) : void
    {
        $DBH = $this->initDB();
        $sth = $DBH->prepare("DELETE FROM users WHERE id = :id");
        $sth->execute(['id' => $deleteUserDTO->id]);
    }

    public function editUser(EditUserDTO $editUserDTO) : void
    {
        $DBH = $this->initDB();
        $sth = $DBH->prepare("UPDATE users
            SET firstname = :firstname, lastname = :lastname
            WHERE id = :id"
        );
        $sth->execute(
            ['firstname' => $editUserDTO->firstName, 'lastname' => $editUserDTO->lastName, 'id' => $editUserDTO->id]
        );
    }
}