<?php

namespace App\Tests\InfrastructureLayer\Postgres;

use App\InfrastructureLayer\Postgres\DbManager;
use App\InfrastructureLayer\Postgres\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;

class SaveUserTest extends WebTestCase
{

    public function testSaveUser()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $entityManager = $container->get('doctrine')->getManagerForClass(Users::class);

        $connection = $entityManager->getConnection();

        $this->assertTrue($connection->connect(), 'Failed to connect to the database');

        $entityManager->persist(new Users(
            Uuid::v1(),
            'test login',
            'test password',
            'test@email.com',
            '88005553535',
            '',
            ''
        ));
        $entityManager->flush();
    }

    public function testConfirmRegistration()
    {

    }
}
