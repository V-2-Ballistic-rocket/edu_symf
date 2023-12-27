<?php

namespace App\InfrastructureLayer\Postgres;

use App\DomainLayer\Address\AddressDTO\SaveAddressDTO;
use App\DomainLayer\Storage\StorageManagerInterface;
use App\DomainLayer\User\Display\UserDisplay;
use App\DomainLayer\User\Profile\DTO\SaveProfileDTO;
use App\DomainLayer\User\Registration\DTO\GetUserByTokenDTO;
use App\DomainLayer\User\Registration\DTO\GotUserDTO;
use App\DomainLayer\User\Registration\DTO\SavedUserDTO;
use App\DomainLayer\User\Registration\DTO\SetConfirmUserDTO;
use App\DomainLayer\User\UserDTO\Collection\UserDtoCollection;
use App\DomainLayer\User\UserDTO\SaveUserDTO;
use App\InfrastructureLayer\Postgres\Address\DTO\GetAddressByIdDTO;
use App\InfrastructureLayer\Postgres\Entity\Address;
use App\InfrastructureLayer\Postgres\Entity\Profile;
use App\InfrastructureLayer\Postgres\Entity\Users;
use App\InfrastructureLayer\Postgres\User\DataMappers\UserCollectionMapper;
use App\InfrastructureLayer\Postgres\User\DataMappers\UserEntityMapper;
use App\InfrastructureLayer\Postgres\User\Profile\DTO\GetProfileByIdDTO;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class DbManager implements StorageManagerInterface
{
    public function __construct(
        private ManagerRegistry      $registry,
        private UserCollectionMapper $collectionMapper,
        private UserEntityMapper     $entityMapper
    )
    {
    }

    public function saveUser(SaveUserDTO $saveUserDTO): SavedUserDTO
    {
        $entityManager = $this->registry->getManagerForClass(Users::class);
        $addressId = $this->saveAddress($saveUserDTO->saveAddressDTO);
        $profileId = $this->saveProfile($saveUserDTO->saveProfileDTO);
        if(!$saveUserDTO->isConfirm)
        {
            $confirmRegistrationToken = Uuid::v1();
        } else {
            $confirmRegistrationToken = null;
        }
        $id = (string)$saveUserDTO->id;
        $user = new Users(
            $id,
            $saveUserDTO->login,
            $saveUserDTO->password,
            $saveUserDTO->email,
            $saveUserDTO->phoneNumber,
            $addressId,
            $profileId,
            $confirmRegistrationToken,
            $saveUserDTO->isConfirm
        );
        if($this->isThere($user))
        {
            $user->setPreviousVersionId($user->getId());
            $id = Uuid::v1();
            $user->setId($id);
        }
        $entityManager->persist($user);
        $entityManager->flush();

        return new SavedUserDTO(
            $id,
            (string)$confirmRegistrationToken,
            $saveUserDTO->email
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
        return $addressRepository->findAll();
    }

    public function getAllProfiles(): array
    {
        $profileRepository = $this->registry->getRepository(Profile::class);
        return $profileRepository->findAll();
    }

    public function confirmRegistration(SetConfirmUserDTO $confirmRegistrationDTO): void
    {
        $repository = $this->registry->getRepository(Users::class);
        $user = $repository->findOneBy(['token' => Uuid::fromString($confirmRegistrationDTO->token)]);
        $user->setConfirmation();
        $entityManager = $this->registry->getManagerForClass(Users::class);
        $entityManager->persist($user);
        $entityManager->flush();
    }

    public function getUserByToken(GetUserByTokenDTO $getUserByTokenDTO): GotUserDTO
    {
        $repository = $this->registry->getRepository(Users::class);
        $user = $repository->findOneBy(['token' => $getUserByTokenDTO->token]);
        $address = $this->getAddressById(new GetAddressByIdDTO($user->getAddressId()));
        $profile = $this->getProfileById(new GetProfileByIdDTO($user->getProfileId()));
        return new GotUserDTO(
            $user->getId(),
            $user->getLogin(),
            $user->getPassword(),
            $user->getEmail(),
            $user->getPhoneNumber(),
            $user->isConfirm(),
            $profile->getFirstName(),
            $profile->getLastName(),
            $profile->getAge(),
            $profile->getToAvatarPath(),
            $address->getCountry(),
            $address->getCity(),
            $address->getStreet(),
            $address->getHouseNumber()
        );
    }

    private function getAddressById(GetAddressByIdDTO $getAddressByIdDTO): Address
    {
        $repository = $this->registry->getRepository(Address::class);
        return $repository->find($getAddressByIdDTO->id);
    }

    private function getProfileById(GetProfileByIdDTO $getProfileByIdDTO): Profile
    {
        $repository = $this->registry->getRepository(Profile::class);
        return $repository->find($getProfileByIdDTO->id);
    }

    private function isThere(Object $entity): bool
    {
        $repository = $this->registry->getRepository($entity::class);
        $result = $repository->find($entity->getId());
        if(!$result)
        {
            return false;
        }
        return true;
    }
}