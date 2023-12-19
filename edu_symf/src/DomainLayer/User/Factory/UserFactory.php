<?php

namespace App\DomainLayer\User\Factory;

use App\DomainLayer\Address\Address;
use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use App\DomainLayer\Address\Factory\AddressFactory;
use App\DomainLayer\User\Exceptions\UserException;
use App\DomainLayer\User\Profile\DTO\CreateProfileDTO;
use App\DomainLayer\User\Profile\Factory\ProfileFactory;
use App\DomainLayer\User\Profile\Profile;
use App\DomainLayer\User\User;
use App\DomainLayer\User\UserDTO\CreateUserDTO;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactory
{
    public function __construct(
        private ValidatorInterface $validator
    )
    {}

    public function createUser(CreateUserDTO $createUserDTO) : ?User
    {
        $id = $createUserDTO->id ?? Uuid::v1();
        $errors = $this->validator->validate($createUserDTO);
        if(count($errors) > 0){
            $errorString = (string) $errors;
            throw new UserException($errors, 400);
        }

        $address = $this->getAddress($createUserDTO->createAddressDTO);
        $profile = $this->getProfile($createUserDTO->createProfileDTO);
        return new User(
            $id,
            $createUserDTO->login,
            $createUserDTO->password,
            $createUserDTO->email,
            $createUserDTO->phoneNumber,
            $profile,
            $address
        );
    }

    private function getAddress(CreateAddressDTO $addressDTO): ?Address
    {
        $addressFactory = new AddressFactory($this->validator);
        return $addressFactory->CreateAddress($addressDTO);
    }
    private function getProfile(CreateProfileDTO $profileDTO): ?Profile
    {
        $profileFactory = new ProfileFactory($this->validator);
        return $profileFactory->createProfile($profileDTO);
    }
}