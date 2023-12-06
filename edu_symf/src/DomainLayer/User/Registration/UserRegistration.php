<?php

namespace App\DomainLayer\User\Registration;

use App\DomainLayer\StorageManagerInterface;
use App\DomainLayer\User\Factory\UserFactory;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use App\DomainLayer\User\UserDTO\UserRegistrationDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validation;

class UserRegistration
{
    /*
     * Что должно быть регистрацией пользователя?
     *
     * 1. Мы приняли информацию о новом пользователе
     * 2. Нужно провалидировать данные о новом пользователе
     * 3. Если информация отвечает правилам:
            - сохранить пользователя и вернуть его идентификатор
          Если информация не отвечает правилам:
            - сообщить что такого пользователя мы сохранить не можем
     * */
    public function registrationUser(UserRegistrationDTO $userRegistrationDTO, StorageManagerInterface $storageManager) : uuid
    {
        $userFactory = new UserFactory(Validation::createValidator());
        $user = $userFactory
            ->createUser(new CreateUserDTO($userRegistrationDTO->firstName, $userRegistrationDTO->lastName));
        if(!$user)
        {
            throw new \Exception('Пользователь с такими данными не может быть сохранен.', 400);
        }
        return $storageManager->saveUser(new SaveUserDTO($user->getFirstName(), $user->getLastName()))->id;
    }
}