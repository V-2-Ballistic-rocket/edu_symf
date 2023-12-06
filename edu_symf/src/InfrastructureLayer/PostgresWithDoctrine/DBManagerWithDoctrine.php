<?php

namespace App\InfrastructureLayer\PostgresWithDoctrine;

use App\InfrastructureLayer\Entity\Users;
use App\InfrastructureLayer\UserDTO\DeleteUserDTO;
use App\InfrastructureLayer\UserDTO\EditUserDTO;
use App\InfrastructureLayer\UserDTO\GetUserDTO;
use App\InfrastructureLayer\UserDTO\GotUserDTO;
use App\InfrastructureLayer\UserDTO\SavedUserDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class DBManagerWithDoctrine
{
    public function __construct(
        private ManagerRegistry $doctrine
    ){}
    public function saveUser(SaveUserDTO $saveUserDTO): SavedUserDTO
    {
        $entityManager = $this->doctrine->getManager();

        $user = new Users();
        $user->setFirstname($saveUserDTO->firstName);
        $user->setLastname($saveUserDTO->lastName);
        $id = Uuid::v1();
        $user->setId($id);

        $entityManager->persist($user);
        $entityManager->flush();

        return new SavedUserDTO($id);
    }

    public function getUser(GetUserDTO $getUserDTO): GotUserDTO
    {
        $entityManager = $this->doctrine->getManager();
        $user = $entityManager->getRepository(Users::class)->find($getUserDTO->id);
        return !$user ? throw new \Exception("Not found", 404) : new GotUserDTO($user->getFirstname(), $user->getLastname());
    }

    public function deleteUser(DeleteUserDTO $deleteUserDTO): void
    {
        $entityManager = $this->doctrine->getManager();
        $user = $entityManager->getRepository(Users::class)->find($deleteUserDTO->id);
        if(!$user)
        {
            throw new \Exception("Not found", 404);
        }
        $entityManager->remove($user);
    }

    public function editUser(EditUserDTO $editUserDTO): void
    {
        // TODO: Implement editUser() method.
    }
}