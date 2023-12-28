<?php

namespace App\Tests\test\Application;

use App\InfrastructureLayer\Postgres\Entity\Address;
use App\InfrastructureLayer\Postgres\Entity\Profile;
use App\InfrastructureLayer\Postgres\Entity\Users;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Uid\Uuid;

class ConfirmRegistration extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?ContainerInterface $container = null;
    private ?EntityManagerInterface $entityManager = null;
    private string $token = '';
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();
        $this->token = (string)Uuid::v1();
        $addressId = (string)Uuid::v1();
        $address = new Address(
            $addressId,
            'confCountry',
            'confCity',
            'confStreet',
            '666C'
        );
        $profileId = (string)Uuid::v1();
        $profile = new Profile(
            $profileId,
            'confName',
            'confLastName',
            24,
            ''
        );
        $user = new Users(
            (string)Uuid::v1(),
            'confLogin',
            'confPassword',
            'conf@email.com',
            '88005553535',
            new DateTime(),
            $addressId,
            $profileId,
            $this->token,
            false,
            null
        );
        $this->entityManager->persist($profile);
        $this->entityManager->persist($address);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    protected function tearDown(): void
    {
        $repository = $this->entityManager->getRepository(Users::class);
        $lastEntity = $repository->findOneBy([], ['editDate' => 'DESC']);
        $this->entityManager->remove($lastEntity);
        $this->entityManager->flush();
//        $lastAddress = $repository->find($lastEntity->getAddressId());
//        $this->entityManager->remove($lastAddress);
//
//        $lastProfile = $repository->find($lastEntity->getProfileId());
//        $this->entityManager->remove($lastProfile);
//
//        $this->entityManager->remove($lastEntity);

        $lastEntity = $repository->findOneBy([], ['editDate' => 'DESC']);
        $this->entityManager->remove($lastEntity);
        $this->entityManager->flush();
    }

    public function testConfirmRegistration():void
    {
        $crawler = $this->client->request('POST', "/users/registration/confirm/{$this->token}");

        $repository = $this->entityManager->getRepository(Users::class);
        $user = $repository->findOneBy(['confirmation' => true], ['editDate' => 'DESC'], 1);

        $this->assertTrue($user->isConfirm());
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', "Успех!");

    }
}