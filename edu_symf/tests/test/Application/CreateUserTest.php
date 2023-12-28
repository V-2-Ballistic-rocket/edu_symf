<?php

namespace App\Tests\test\Application;

use App\InfrastructureLayer\Postgres\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateUserTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?ContainerInterface $container = null;
    private ?EntityManagerInterface $entityManager = null;
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();

    }

    protected function tearDown(): void
    {
        $repository = $this->entityManager->getRepository(Users::class);
        $lastEntity = $repository->findOneBy([], ['editDate' => 'DESC'], 1);
        $this->entityManager->remove($lastEntity);
        $this->entityManager->flush();
    }

    /**
     * @dataProvider payloadProvider
     */
    public function testCreateUser($email, $data): void
    {
        //исходные данные
        $expectedResult = array($data['login'], $data['password'], $data['email'], $data['phone_number']);

        //создание пользователя
        $crawler = $this->client->request('POST', '/users', $data);

        //вызываем из хранилища последнего созданного пользователя
        $repository = $this->entityManager->getRepository(Users::class);
        $lastEntity = $repository->findOneBy([], ['editDate' => 'DESC'], 1);
        $actualResult = array($lastEntity->getLogin(), $lastEntity->getPassword(), $lastEntity->getEmail(), $lastEntity->getPhoneNumber());

        //сравниваем исходные данные с теми, что достали из хранилища
        $this->assertEquals($expectedResult, $actualResult);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', "Письмо с подтверждением отправлено на почту {$email}!");
    }

    public function payloadProvider(): array
    {
        $email = 'email@email.com';
        return [
            [
                'email' => $email,
                'data' => [
                    'login' => 'login',
                    'password' => 'password',
                    'email' => $email,
                    'phone_number' => '86005553535',
                    'first_name' => 'ggdrteee',
                    'last_name' => 'eeenamee',
                    'age' => '110',
                    'path_to_avatar' => 'wqfee',
                    'country' => 'qrwertrye',
                    'city' => 'bfrdrge',
                    'street' => 'swrerew',
                    'house_number' => '312Ae'
                ]
            ]
        ];
    }
}