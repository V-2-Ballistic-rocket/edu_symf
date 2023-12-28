<?php

namespace App\Tests\test\Unit\Domain\User\Profile\Factory;

use App\DomainLayer\User\Profile\Avatar\Avatar;
use App\DomainLayer\User\Profile\DTO\CreateProfileDTO;
use App\DomainLayer\User\Profile\Factory\ProfileFactory;
use App\DomainLayer\User\Profile\Profile;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProfileFactoryTest extends TestCase
{
    /**
     * @dataProvider validProfileProvider
     */
    public function testCreateProfile($createProfileDto)
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('validate')
            ->with($createProfileDto);
        $factory = new ProfileFactory($validator);
        $actualProfile = $factory->createProfile($createProfileDto);
        $expectedProfile = new Profile(
            $createProfileDto->firstName,
            $createProfileDto->lastName,
            $createProfileDto->age,
            new Avatar($createProfileDto->toAvatarPath)
        );
        $this->assertEquals($expectedProfile, $actualProfile);
    }

    public function validProfileProvider(): array
    {
        return [
            ['createProfileDto' => new CreateProfileDTO(
                'Alan',
                'Tomas',
                29,
                'test'
            )]
        ];
    }
}