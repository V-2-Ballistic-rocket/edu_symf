<?php

namespace App\Controller;

use App\DomainLayer\User\Registration\UserRegistration;
use App\DomainLayer\User\UserDTO\UserRegistrationDTO;
use App\InfrastructureLayer\Entity\Users;
use App\InfrastructureLayer\PostgresWithDoctrine\DBManagerWithDoctrine;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class UserController extends AbstractController
{
/*
 * получение данных
 * валидация
 * сохранение
 * возврат id
 * */
    #[Route('/user', name: 'create_user')]
    public function createUser(ManagerRegistry $doctrine) : JsonResponse
    {
        $firstName = '';
        $lastName = '';
        $entityManager = $doctrine->getManager();
        $userRegistration = new UserRegistration();
        try {
            $id = $userRegistration->registrationUser(
                new UserRegistrationDTO($firstName, $lastName),
                new DBManagerWithDoctrine($doctrine));
        } catch (\Exception $e) {
            return new JsonResponse(
                $e->getMessage(),
                $e->getCode()
            );
        }
        return new JsonResponse(
            'Saved new user with id' . $id,
            status: 200
        );
    }
}
