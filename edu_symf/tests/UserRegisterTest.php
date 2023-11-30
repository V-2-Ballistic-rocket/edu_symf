<?php

namespace App\Tests;

use App\DomainLayer\User\CreateUserDTO;
use App\DomainLayer\User\UserFactory;
use PHPUnit\Framework\TestCase;

class UserRegisterTest extends TestCase
{
    public function testSomething(): void
    {
        /*
         * 1. получение данных
         * 2. валидация данных (внутри фабрики сущности)
         * 3. создание сущности по валидным данным (внутри фабрики сущности)
         * 4. вызов сущности из таблицы
         * 5. сопоставление ожидаемого и фактического результата
         * Если на всех этапах не было выброшено исключение, а так же результаты сошлись, то тест пройден успешно.
         */

    }
}
