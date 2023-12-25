<?php

namespace App\DomainLayer\User\Profile\Factory;

use App\DomainLayer\User\Profile\Avatar\Avatar;
use App\DomainLayer\User\Profile\DTO\CreateProfileDTO;
use App\DomainLayer\User\Profile\Exceptions\ProfileException;
use App\DomainLayer\User\Profile\Profile;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProfileFactory
{
    public function __construct(
        private ValidatorInterface $validator
    ){}

    public function createProfile(CreateProfileDTO $createProfileDTO): ?Profile
    {
        $errors = $this->validator->validate($createProfileDTO);
        if(count($errors) > 0){
            $errorString = (string) $errors;
            throw new ProfileException($errors, 400);
        }
        return new Profile(
            $createProfileDTO->firstName,
            $createProfileDTO->lastName,
            $createProfileDTO->age,
            new Avatar($createProfileDTO->toAvatarPath)
        );
    }
}