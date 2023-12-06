<?php

namespace App\Tests;

use App\DomainLayer\StorageManagerInterface;
use App\DomainLayer\User\Factory\UserFactory;
use App\DomainLayer\User\Registration\UserRegistration;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use App\DomainLayer\User\UserDTO\UserRegistrationDTO;
use App\InfrastructureLayer\PostgresWithPDO\DBManagerWithPDO;
use App\InfrastructureLayer\UserDTO\DeleteUserDTO;
use App\InfrastructureLayer\UserDTO\GetUserDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRegistrationTest extends KernelTestCase
{
    /*
     * как протестировать регистрацию пользователя
     *
     * 1. получаем информацию из заявления на регистрацию
     * 2. проверяем правильно ли заполнено заявление на регистрацию
     * 3. формируем из заявления нового пользователя
     * 4. сохраняем нового пользователя
     *
     * 2.1. пробуем сохранить пользователя с неправильно заполненным заявлением
     * 2.2. проверяем, забраковал ли регистратор это заявление
     *
     * 5. проверяем сохранился ли пользователь с правильно заполненным заявлением
     * 5.1. получаем из хранилища сохраненного пользователя
     * 5.2. сравниваем данные пользователя из хранилища и из заявления
     */


    /**
     * @dataProvider whenUserIsValidProvider
     */
    public function testUserRegistrationWhenUserIsValid($firstName, $lastName): void
    {
        $userRegistrationDTO = new UserRegistrationDTO($firstName, $lastName);

        self::bootKernel();
        $container = self::getContainer();
        $userFactory = $container->get(UserFactory::class);
        $user = $userFactory->createUser(
            new CreateUserDTO($userRegistrationDTO->firstName, $userRegistrationDTO->lastName)
        );

        $storageManager = $container->get(StorageManagerInterface::class);
        $savedUserDTO = $storageManager->saveUser(new SaveUserDTO($user->getFirstName(), $user->getLastName()));

        $gotUserDTO = $storageManager->getUser(new GetUserDTO($savedUserDTO->id));

        $this->assertEquals(
            array($firstName, $lastName),
            array($gotUserDTO->firstName, $gotUserDTO->lastName)
        );

        $storageManager->deleteUser($savedUserDTO->id);
    }
    public function whenUserIsValidProvider() : array
    {
        return [
            "when user is valid" =>
            [
                'firstName' => 'Vlad',
                'lastName' => 'Rimskiy'
            ]
        ];
    }

    /**
     * @dataProvider validUserRegistrationTestMethodProvider
     */
    public function testUserRegisterMethod($firstName, $lastName): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $storageManager = $container->get(StorageManagerInterface::class);

        $userRegistration = new UserRegistration();

        $id = $userRegistration->registrationUser(new UserRegistrationDTO($firstName, $lastName), $storageManager);

        $dbManager = new DBManagerWithPDO();

        $getUserDTO = $dbManager->getUser(new GetUserDTO($id));

        $this->assertEquals(
            array($getUserDTO->firstName, $getUserDTO->lastName),
            array($firstName, $lastName));

        $dbManager->deleteUser(new DeleteUserDTO($id));
    }
    public function validUserRegistrationTestMethodProvider(): array
    {
        return [
            'when user is valid' =>
                [
                    'firstName' => 'Alexandr',
                    'lastName' => 'Ivanov'
                ]
        ];
    }
}
