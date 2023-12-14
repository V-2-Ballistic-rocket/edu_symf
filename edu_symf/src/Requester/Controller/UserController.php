<?php

namespace App\Requester\Controller;

use App\DomainLayer\User\Registration\UserRegistration;
use App\DomainLayer\User\UserDTO\Collection\UserCollectionDtoMapperInterface;
use App\DomainLayer\User\UserDTO\UserRegistrationDTO;
use App\InfrastructureLayer\Postgres\DBManagerWithDoctrine;
use App\Requester\Controller\DTO\UserRegistrationRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private DBManagerWithDoctrine $dbManager,
        private UserCollectionDtoMapperInterface $userCollectionDtoMapper,
        private UserRegistration $userRegistration
    ){
    }


    #[Route('/users', name: 'create_user', methods: ["POST"])]
    public function createUser(
        #[ValueResolver('user_registration_request_dto')] UserRegistrationRequestDTO $dto,
    ) : JsonResponse
    {

        $userRegistrationDTO = new UserRegistrationDTO(
            $dto->login,
            $dto->password,
            $dto->email,
            $dto->phoneNumber,
            $dto->firstName,
            $dto->lastName,
            $dto->age,
            $dto->pathToAvatar,
            $dto->country,
            $dto->city,
            $dto->street,
            $dto->houseNumber
        );
        try {
            $id = $this->userRegistration
                ->registrationUser($userRegistrationDTO, $this->dbManager)
                ->id;
        } catch (\Exception $e) {
            return new JsonResponse(
                $e->getMessage(),
                $e->getCode()
            );
        }
        return new JsonResponse(
            "Saved new user with id - {$id}",
            status: 200
        );
    }

    #[Route('/users', name: 'app_get_user', methods: ['GET'])]
    public function index(): Response
    {
        $userCollection = $this->dbManager->getUsers();

        return new Response(
            $this->userCollectionDtoMapper->mapToJson($userCollection),
            status: 200
        );
    }
}
