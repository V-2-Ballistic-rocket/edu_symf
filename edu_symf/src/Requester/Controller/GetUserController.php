<?php

namespace App\Requester\Controller;

use App\InfrastructureLayer\Postgres\DBManagerWithDoctrine;
use App\InfrastructureLayer\UserDTO\GetUserDTO;
use App\Requester\MapRequestPayload\GetRequestPayloadMapper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class GetUserController extends AbstractController
{
    public function __construct(
        private GetRequestPayloadMapper $requestPayloadMapper
    ){
    }
    #[Route('/users', name: 'app_get_user', methods: ['GET'])]
    public function index(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $content = $request->getContent();

        $requestPayload = json_decode($content, true);
        $mapping = $this->requestPayloadMapper->mapRequestPayload($requestPayload);

        $dbManager = new DBManagerWithDoctrine($doctrine);
        $gotUserDTO = $dbManager->getUser(new GetUserDTO(Uuid::fromString($mapping['id'])));

        return new JsonResponse(
            "Saved user first name - {$gotUserDTO->firstName}".
            "Saved user last name - {$gotUserDTO->lastName}".
            "Saved user age - {$gotUserDTO->age}".
            "Saved user email - {$gotUserDTO->email}".
            "Saved user phone number - {$gotUserDTO->phoneNumber}",
            status: 200
        );
    }
}
