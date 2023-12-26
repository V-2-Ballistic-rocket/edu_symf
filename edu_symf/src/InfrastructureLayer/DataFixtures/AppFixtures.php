<?php

namespace App\InfrastructureLayer\DataFixtures;

use App\InfrastructureLayer\Postgres\Entity\Address;
use App\InfrastructureLayer\Postgres\Entity\Profile;
use App\InfrastructureLayer\Postgres\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    const REFERENCE = 'user';
    public function load(ObjectManager $manager)
    {
        $addressId = Uuid::V1();
        $address = new Address(
            $addressId,
            'Testandia',
            'Testsantos',
            'Teststreet',
            '64/Test'
        );
        $profileId = Uuid::v1();
        $profile = new Profile(
            $profileId,
            'Testivald',
            'Testov',
            64,
            'to_avatar_test_path'
        );
        $userId = Uuid::v1();
        $userToken = Uuid::v1();
        $user = new Users(
            $userId,
            'test_login',
            'test_password',
            'test@email.com',
            '88005553535',
            $addressId,
            $profileId,
            $userToken
        );
        $manager->persist($address);
        $manager->persist($profile);
        $manager->persist($user);
        $manager->flush();
        $this->addReference(self::REFERENCE, $user);
    }
}
