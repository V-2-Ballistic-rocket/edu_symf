<?php

namespace App\Requester\Controller;

use App\DomainLayer\User\Registration\UserRegistration;
use App\DomainLayer\User\UserDTO\UserRegistrationDTO;
use App\InfrastructureLayer\Postgres\DBManagerWithDoctrine;
use App\Requester\MapRequestPayload\PostRequestPayloadMapper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class UserController extends AbstractController
{
    public function __construct(
        private PostRequestPayloadMapper $requestPayloadMapper
    ){
    }
    #[Route('/users', name: 'create_user', methods: ["POST"])]
    public function createUser(Request $request, ManagerRegistry $doctrine) : JsonResponse
    {
        $content = $request->getContent();

        $requestPayload = json_decode($content, true);

        $mapping = $this->requestPayloadMapper->mapRequestPayload($requestPayload);
        $firstName = $mapping['first_name'] ?? null;
        $lastName = $mapping['last_name'] ?? null;
        $age = $mapping['age'] ?? null;
        $email = $mapping['email'] ?? null;
        $phoneNumber = $mapping['phone_number'] ?? null;

        $userRegistration = new UserRegistration();
        try {
            $id = $userRegistration->registrationUser(
                new UserRegistrationDTO(
                    $firstName,
                    $lastName,
                    $age,
                    $email,
                    $phoneNumber
                ),
                new DBManagerWithDoctrine($doctrine))
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
}
