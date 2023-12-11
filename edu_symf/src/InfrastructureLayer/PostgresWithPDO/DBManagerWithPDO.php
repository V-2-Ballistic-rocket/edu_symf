<?php

namespace App\InfrastructureLayer\PostgresWithPDO;

use App\DomainLayer\Storage\StorageManagerInterface;
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
    private string $connectionParams = 'pgsql:host=postgres;dbname=app';
    private string $user = 'postgres';
    private string $password = 'postgres';
    private function initDB()
    {
        return $DBH = new PDO($this->connectionParams, $this->user, $this->password);
    }

    public function saveUser(SaveUserDTO $saveUserDTO) : SavedUserDTO
    {
        $DBH = $this->initDB();
        $sth = $DBH->prepare("INSERT INTO users (id, first_name, last_name, age, email, phone_number)
        VALUES (:id, :first_name, :last_name, :age, :email, :phone_number);");
        $id = Uuid::v1();
        $sth->execute(
            [
                'id' => $id,
                'first_name' => $saveUserDTO->firstName,
                'last_name' => $saveUserDTO->lastName,
                'age' => $saveUserDTO->age,
                'email' => $saveUserDTO->email,
                'phone_number' => $saveUserDTO->phoneNumber
        ]);
        return new SavedUserDTO($id);
    }

    public function getUser(GetUserDTO $getUserDTO) : GotUserDTO
    {
        if(!$getUserDTO->id){
            throw new \Exception('Пользователь не найден', 404);
        }
        $DBH = $this->initDB();
        $sth = $DBH->prepare("SELECT first_name, last_name, age, email, phone_number FROM users WHERE id = :id;");
        $sth->execute(['id' => $getUserDTO->id]);
        $result = $sth->fetch(PDO::PARAM_STR);

        return new GotUserDTO(
            $result['first_name'],
            $result['last_name'],
            $result['age'],
            $result['email'],
            $result['phone_number']
        );
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
            SET first_name = :first_name, last_name = :last_name, age = :age, email = :email, phone_number = :phone_number
            WHERE id = :id"
        );
        $sth->execute(
            [
                'first_name' => $editUserDTO->firstName,
                'last_name' => $editUserDTO->lastName,
                'age' => $editUserDTO->age,
                'email' => $editUserDTO->email,
                'phone_number' => $editUserDTO->phoneNumber,
                'id' => $editUserDTO->id
            ]
        );
    }
}