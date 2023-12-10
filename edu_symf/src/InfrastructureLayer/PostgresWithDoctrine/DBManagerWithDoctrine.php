<?php

namespace App\InfrastructureLayer\PostgresWithDoctrine;

use App\DomainLayer\StorageManagerInterface;
use App\InfrastructureLayer\Entity\Users;
use App\InfrastructureLayer\UserDTO\DeleteUserDTO;
use App\InfrastructureLayer\UserDTO\EditUserDTO;
use App\InfrastructureLayer\UserDTO\GetUserDTO;
use App\InfrastructureLayer\UserDTO\GotUserDTO;
use App\InfrastructureLayer\UserDTO\SavedUserDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class DBManagerWithDoctrine implements StorageManagerInterface
{
    public function __construct(
        private ManagerRegistry $registry
    ){}
    public function saveUser(SaveUserDTO $saveUserDTO): SavedUserDTO
    {
        $entityManager = $this->registry->getManagerForClass(Users::class);

        $user = new Users();
        $user->setFirstname($saveUserDTO->firstName);
        $user->setLastname($saveUserDTO->lastName);
        $user->setAge($saveUserDTO->age);
        $user->setEmail($saveUserDTO->email);
        $user->setPhoneNumber($saveUserDTO->phoneNumber);
        $id = Uuid::v1();
        $user->setId($id);

        $entityManager->persist($user);
        $entityManager->flush();

        return new SavedUserDTO($id);
    }

    public function getUser(GetUserDTO $getUserDTO): GotUserDTO
    {
//        $entityManager = $this->registry->getManager(Users::class);
//        $connection = $entityManager->getConnection();
//        $pdo = $connection->getNativeConnection();
//        if($pdo === null){
//            var_dump('eorigjierjgoi');
//        }
//        $sth = $pdo->prepare('SELECT first_name, last_name, age, email, phone_number FROM users WHERE id = :id');
//        $sth->execute(['id' => $getUserDTO->id]);
//
//        $result = $sth->fetchAllAssociative();
//
//        return new GotUserDTO(
//            $result['first_name'],
//            $result['last_name'],
//            $result['age'],
//            $result['email'],
//            $result['phone_number']
//        );

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

    public function deleteUser(DeleteUserDTO $deleteUserDTO): void
    {
        $entityManager = $this->entityManager->getManager();
        $user = $entityManager->getRepository(Users::class)->find($deleteUserDTO->id);
        if(!$user)
        {
            throw new \Exception("Not found", 404);
        }
        $entityManager->remove($user);
        $entityManager->flush();
    }

    public function editUser(EditUserDTO $editUserDTO): void
    {
        // TODO: Implement editUser() method.
    }
}