<?php

namespace App\DomainLayer\User\Factory;

use App\DomainLayer\Address\Address;
use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use App\DomainLayer\Address\Factory\AddressFactory;
use App\DomainLayer\User\Profile\Avatar\Avatar;
use App\DomainLayer\User\Profile\DTO\CreateProfileDTO;
use App\DomainLayer\User\Profile\Profile;
use App\DomainLayer\User\Profile\ProfileFactory;
use App\DomainLayer\User\User;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactory
{
    public function __construct(
        private ValidatorInterface $validator
    )
    {

    }

    public function createUser(CreateUserDTO $createUserDTO) : ?User
    {

        $errors = $this->validator->validate($createUserDTO);
        if(count($errors) > 0){
            $errorString = (string) $errors;
            return null;
        }

        $address = $this->getAddress($createUserDTO->createAddressDTO);
        $profile = $this->getProfile($createUserDTO->createProfileDTO);
        return new User(
            Uuid::v1(),
            $createUserDTO->login,
            $createUserDTO->password,
            $createUserDTO->email,
            $createUserDTO->phoneNumber,
            $profile,
            $address
        );
    }

    public function getAddress(CreateAddressDTO $addressDTO): ?Address
    {
        $addressFactory = new AddressFactory($this->validator);
        return $addressFactory->CreateAddress($addressDTO);
    }
    public function getProfile(CreateProfileDTO $profileDTO): ?Profile
    {
        $profileFactory = new ProfileFactory($this->validator);
        return $profileFactory->createProfile($profileDTO);
    }
}