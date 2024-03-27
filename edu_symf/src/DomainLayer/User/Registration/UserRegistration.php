<?php

namespace App\DomainLayer\User\Registration;

use App\DomainLayer\Mail\DTO\SendConfirmMailDTO;
use App\DomainLayer\Mail\Exceptions\SendMailException;
use App\DomainLayer\Mail\MailManagerInterface;
use App\DomainLayer\Storage\Exceptions\SaveUserException;
use App\DomainLayer\Storage\StorageManagerInterface;
use App\DomainLayer\User\Exceptions\ConfirmUserException;
use App\DomainLayer\User\Factory\UserFactory;
use App\DomainLayer\User\Registration\DataMappers\GotUserDtoMapper;
use App\DomainLayer\User\Registration\DataMappers\UserMapper;
use App\DomainLayer\User\Registration\DataMappers\UserRegistrationDtoMapper;
use App\DomainLayer\User\Registration\DTO\GetUserByTokenDTO;
use App\DomainLayer\User\Registration\DTO\GotUserDTO;
use App\DomainLayer\User\Registration\DTO\SavedUserDTO;
use App\DomainLayer\User\Registration\DTO\SetConfirmUserDTO;
use App\DomainLayer\User\Registration\DTO\UserRegistrationDTO;
use App\DomainLayer\User\User;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use Symfony\Component\Validator\Validation;

class UserRegistration
{
    public function __construct(
        private ?StorageManagerInterface   $storageManager = null,
        private ?MailManagerInterface      $mailManager = null,
        private ?GotUserDtoMapper          $gotUserDtoMapper = null,
        private ?UserMapper                $userMapper = null,
        private ?UserRegistrationDtoMapper $userRegistrationDtoMapper = null
    )
    {
    }

    public function registrationUser(UserRegistrationDTO $userRegistrationDTO): SavedUserDTO
    {

        $createUserDTO = $this->userRegistrationDtoMapper->mapToCreateUserDTO($userRegistrationDTO);

        $user = $this->createUser($createUserDTO);

        try {
            $savedUserDto = $this->saveUser($user);
        } catch (\Exception $exception) {
            throw new SaveUserException();
        }

        try {
            $this->mailManager->sendConfirmEmail(new SendConfirmMailDTO($savedUserDto->confirmRegistrationToken, $user->getEmail()));
        } catch (\Exception $exception) {
            throw new SendMailException();
        }
        return $savedUserDto;
    }

    public function confirmRegistration(SetConfirmUserDTO $confirmRegistrationDTO): void
    {

        $gotUserDTO = $this->storageManager->getUserByToken(new GetUserByTokenDTO($confirmRegistrationDTO->token));
        $createUserDTO = $this->gotUserDtoMapper->mapToCreateUserDTO($gotUserDTO);
        $user = $this->createUser($createUserDTO);

        $user->setIsConfirm(true);

        try {
            $this->saveUser($user);

        } catch (\Exception $e) {
            throw new ConfirmUserException();
        }
    }

    private function createUser(CreateUserDTO $createUserDTO): User
    {
        $userFactory = new UserFactory(Validation::createValidator());

        return $userFactory->createUser($createUserDTO);
    }

    private function saveUser(User $user): SavedUserDTO
    {
        $saveUserDTO = $this->userMapper->mapToSaveUserDto($user);

        return $this->storageManager->saveUser($saveUserDTO);
    }
}