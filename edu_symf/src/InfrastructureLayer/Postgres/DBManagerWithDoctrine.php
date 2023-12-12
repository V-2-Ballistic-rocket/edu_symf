<?php

namespace App\InfrastructureLayer\Postgres;

use App\DomainLayer\Storage\StorageManagerInterface;
use App\InfrastructureLayer\Entity\Users;
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
        $entityManager = $this->registry->getManagerForClass(Users::class);
        $userRepository = $entityManager->getRepository(Users::class);

        $user = $userRepository->find($getUserDTO->id);

        return new GotUserDTO(
            $user->getFirstName(),
            $user->getLastName(),
            $user->getAge(),
            $user->getEmail(),
            $user->getPhoneNumber()
        );
//        $connection = $this->registry->getConnection();
//        $DBH = $connection->getWrappedConnection();
//
//        if(!$getUserDTO->id){
//            throw new \Exception('Пользователь не найден', 404);
//        }
//
//        $sth = $DBH->prepare("SELECT first_name, last_name, age, email, phone_number FROM users WHERE id = :id;");
//        $sth->execute(['id' => $getUserDTO->id]);
//        $result = $sth->fetch(PDO::PARAM_STR);
//
//        return new GotUserDTO(
//            $result['first_name'],
//            $result['last_name'],
//            $result['age'],
//            $result['email'],
//            $result['phone_number']
//        );
    }
}