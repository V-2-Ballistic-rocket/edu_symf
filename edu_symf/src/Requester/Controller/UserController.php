<?php

namespace App\Requester\Controller;

use App\DomainLayer\Exceptions\DomainException;
use App\DomainLayer\Mail\DTO\SendConfirmMailDTO;
use App\DomainLayer\User\Exceptions\ConfirmUserException;
use App\DomainLayer\User\Registration\DataMappers\UserRegistrationDtoMapper;
use App\DomainLayer\User\Registration\DTO\SetConfirmUserDTO;
use App\DomainLayer\User\Registration\DTO\UserRegistrationDTO;
use App\DomainLayer\User\Registration\UserRegistration;
use App\DomainLayer\User\UserDTO\Collection\UserCollectionDtoMapperInterface;
use App\InfrastructureLayer\Mailer\MailManager;
use App\InfrastructureLayer\Postgres\DbManager;
use App\Requester\Controller\DataMappers\UserRegistrationRequestDtoMapper;
use App\Requester\Controller\DTO\UserRegistrationRequestDTO;
use App\View\EmailSchema\ConfirmRegistrationByEmailSchema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private DbManager                        $dbManager,
        private UserCollectionDtoMapperInterface $userCollectionDtoMapper,
        private UserRegistration                 $userRegistration,
        private UserRegistrationRequestDtoMapper $userRegistrationRequestDtoMapper,
        private MailManager                      $mailManager,
    )
    {

    }

    #[Route('/users', name: 'create_user', methods: ["POST"])]
    public function createUser(
        #[ValueResolver('user_registration_request_dto')] UserRegistrationRequestDTO $dto,
    ): JsonResponse
    {

        $userRegistrationDTO = $this->userRegistrationRequestDtoMapper
            ->mapToUserRegistrationDto($dto);
        try {
            $savedUserDTO = $this->userRegistration
                ->registrationUser($userRegistrationDTO);
        } catch (DomainException $e) {
            return new JsonResponse(
                $e->getMessage(),
                $e->getCode()
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                $e->getMessage(),
                $e->getCode()
            );
        }
        return new JsonResponse(
            "Saved new user with id - {$savedUserDTO->id}",
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

    #[Route('/users/registration/confirm/{token}', name: 'confirm_registration')]
    public function confirmRegistration(string $token): Response
    {
        try {
            $this->userRegistration->confirmRegistration(new SetConfirmUserDTO($token));
        } catch (ConfirmUserException $e) {
            return new Response(
                $e->getMessage(),
                $e->getCode()
            );
        }
        return new Response(
            '',
            200
        );
    }
}
