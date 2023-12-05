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

class UserRegisterTest extends KernelTestCase
{


    /**
     * @dataProvider validUserRegistrationTestProvider
     */
    public function testUserRegister($firstName, $lastName): void
    {
        /*
         * 1. получение данных от пользователя (из запроса)
         * 2. валидация данных (внутри фабрики сущности)
         * 3. создание сущности по валидным данным (внутри фабрики сущности)
         * 4. сохранение сущности в хранилище
         * 4. получение сущности из хранилища
         * 5. сопоставление ожидаемого и фактического результата
         * Если на всех этапах не было выброшено исключение, а так же результаты сошлись, то тест пройден успешно.
         * 6. почистить за собой в таблице
         */
        self::bootKernel();
        $container = self::getContainer();
        $userFactory = $container->get(UserFactory::class);

        $user = $userFactory->createUser(new CreateUserDTO($firstName, $lastName));

        $saveUserDTO = new SaveUserDTO($user->getFirstName(), $user->getLastName());

        $dbManager = new DBManagerWithPDO();
        $id = $dbManager->saveUser($saveUserDTO)->id;

        $gotUserDTO = $dbManager->getUser(new GetUserDTO($id));

        $this->assertEquals(
            array($gotUserDTO->firstName, $gotUserDTO->lastName),
            array($saveUserDTO->firstName, $saveUserDTO->lastName));

        $dbManager->deleteUser(new DeleteUserDTO($id));
    }
    public function validUserRegistrationTestProvider():array
    {
        return [
            'when user is valid' =>
            [
                'firstName' => 'Oleg',
                'lastName' => 'Petrov'
            ]
        ];
    }

    /**
     * @dataProvider validUserRegistrationTestMethodProvider
     */
    public function testUserRegisterMethod($firstName, $lastName): void
    {
        /*
         * 1. получение данных от пользователя (из запроса)
         * 2. валидация данных (внутри фабрики сущности)
         * 3. создание сущности по валидным данным (внутри фабрики сущности)
         * 4. сохранение сущности в хранилище
         * 4. получение сущности из хранилища
         * 5. сопоставление ожидаемого и фактического результата
         * Если на всех этапах не было выброшено исключение, а так же результаты сошлись, то тест пройден успешно.
         * 6. почистить за собой в таблице
         */
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
    public function validUserRegistrationTestMethodProvider():array
    {
        return [
            'when user is valid' =>
            [
                'firstName' => 'Oleg',
                'lastName' => 'Petrov'
            ]
        ];
    }
}
