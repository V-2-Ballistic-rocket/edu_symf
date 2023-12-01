<?php

namespace App\Tests;


use App\DomainLayer\User\CreateUserDTO;
use App\DomainLayer\User\UserFactory;
use App\InfrastructureLayer\PostgresWithPDO\DBManager;
use App\InfrastructureLayer\SaveUserDTO;
use PHPUnit\Framework\TestCase;

class UserRegisterTest extends TestCase
{


    /**
     * @dataProvider validUserRegistrationTestProvider
     */
    public function testSomething($firstName, $lastName): void
    {
        /*
         * 1. получение данных
         * 2. валидация данных (внутри фабрики сущности)
         * 3. создание сущности по валидным данным (внутри фабрики сущности)
         * 4. вызов сущности из таблицы
         * 5. сопоставление ожидаемого и фактического результата
         * Если на всех этапах не было выброшено исключение, а так же результаты сошлись, то тест пройден успешно.
         * 6. почистить за собой в таблице
         */

        $user = UserFactory::createUser(new CreateUserDTO($firstName, $lastName));

        $saveUserDTO = new SaveUserDTO($user->getFirstName(), $user->getLastName());

        $dbManager = new DBManager();
        $id = $dbManager->saveUser($saveUserDTO);
        $getUserDTO = $dbManager->getUser($id);

        $this->assertEquals(
            array($getUserDTO->firstName, $getUserDTO->lastName),
            array($saveUserDTO->firstName, $saveUserDTO->lastName));

        $dbManager->deleteUser($id);
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
}
