<?php

namespace App\InfrastructureLayer\Postgres;

use App\DomainLayer\Address\AddressDTO\SaveAddressDTO;
use App\DomainLayer\Storage\StorageManagerInterface;
use App\DomainLayer\User\Profile\DTO\SaveProfileDTO;
use App\DomainLayer\User\Registration\DTO\setConfirmUserDTO;
use App\DomainLayer\User\Registration\DTO\SavedUserDTO;
use App\DomainLayer\User\UserDTO\Collection\UserDtoCollection;
use App\DomainLayer\User\UserDTO\SaveUserDTO;
use App\InfrastructureLayer\Postgres\Entity\Address;
use App\InfrastructureLayer\Postgres\Entity\Profile;
use App\InfrastructureLayer\Postgres\Entity\Users;
use App\InfrastructureLayer\Postgres\User\DataMappers\UserCollectionMapper;
use App\InfrastructureLayer\Postgres\User\DataMappers\UserEntityMapper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class DbManager implements StorageManagerInterface
{
    public function __construct(
        private ManagerRegistry $registry,
        private UserCollectionMapper $collectionMapper,
        private UserEntityMapper $entityMapper
    )
    {}
    public function saveUser(SaveUserDTO $saveUserDTO): SavedUserDTO
    {

        $entityManager = $this->registry->getManagerForClass(Users::class);

        $addressId = $this->saveAddress($saveUserDTO->saveAddressDTO);

        $profileId = $this->saveProfile($saveUserDTO->saveProfileDTO);

        $id = Uuid::v1();
        $confirmRegistrationToken = Uuid::v1();
        $user = new Users(
            $id,
            $saveUserDTO->login,
            $saveUserDTO->password,
            $saveUserDTO->email,
            $saveUserDTO->phoneNumber,
            $addressId,
            $profileId,
            (string)$confirmRegistrationToken
        );
        $entityManager->persist($user);
        try {
            $entityManager->flush();
        } catch (\Exception $e)
        {
            dd($e->getMessage(), $e->getCode(), $e->getTraceAsString());
        }

        return new SavedUserDTO(
            $id,
            (string)$confirmRegistrationToken
        );
    }

    public function saveAddress(SaveAddressDTO $saveAddressDTO): Uuid
    {
        $entityManager = $this->registry->getManagerForClass(Address::class);
        $id = Uuid::v1();
        $address = new Address(
            $id,
            $saveAddressDTO->country,
            $saveAddressDTO->city,
            $saveAddressDTO->street,
            $saveAddressDTO->houseNumber
        );
        $entityManager->persist($address);
        $entityManager->flush();

        return $id;
    }

    public function saveProfile(SaveProfileDTO $saveProfileDTO): Uuid
    {
        $entityManager = $this->registry->getManagerForClass(Profile::class);
        $id = Uuid::v1();
        $profile = new Profile(
            $id,
            $saveProfileDTO->firstName,
            $saveProfileDTO->lastName,
            $saveProfileDTO->age,
            $saveProfileDTO->avatar->getPathToFile()
        );
        $entityManager->persist($profile);
        $entityManager->flush();

        return $id;
    }

    public function getUsers(): UserDtoCollection
    {
        $entityManager = $this->registry->getManagerForClass(Users::class);
        $userRepository = $entityManager->getRepository(Users::class);

        $users = $userRepository->findAll();

        $address = $this->getAllAddress();
        $profiles = $this->getAllProfiles();

        $data = $this->entityMapper->mapToArray($users, $profiles, $address);

        return $this->collectionMapper->mapFromArray($data);
    }

    public function getAllAddress(): array
    {
        $addressRepository = $this->registry->getRepository(Address::class);
        return  $addressRepository->findAll();
    }

    public function getAllProfiles(): array
    {
        $profileRepository = $this->registry->getRepository(Profile::class);
        return  $profileRepository->findAll();
    }

    public function confirmRegistration(setConfirmUserDTO $confirmRegistrationDTO): void
    {
        $repository = $this->registry->getRepository(Users::class);
        $user = $repository->findOneBy(['token' => Uuid::fromString($confirmRegistrationDTO->token)]);
        $user->setConfirmation();
        $entityManager = $this->registry->getManagerForClass(Users::class);
        $entityManager->persist($user);
        $entityManager->flush();
    }
}