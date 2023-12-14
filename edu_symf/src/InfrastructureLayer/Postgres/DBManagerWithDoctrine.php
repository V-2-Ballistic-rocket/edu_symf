<?php

namespace App\InfrastructureLayer\Postgres;

use App\DomainLayer\Address\AddressDTO\SaveAddressDTO;
use App\DomainLayer\Storage\StorageManagerInterface;
use App\DomainLayer\User\Profile\DTO\SaveProfileDTO;
use App\DomainLayer\User\UserDTO\Collection\UserDtoCollection;
use App\DomainLayer\User\UserDTO\SaveUserDTO;
use App\InfrastructureLayer\Entity\Address;
use App\InfrastructureLayer\Entity\Profile;
use App\InfrastructureLayer\Entity\Users;
use App\InfrastructureLayer\User\DataMappers\UserCollectionMapper;
use App\InfrastructureLayer\User\DataMappers\UserEntityMapper;
use App\InfrastructureLayer\User\DTO\GetUserDTO;
use App\InfrastructureLayer\User\DTO\GotUserDTO;
use App\InfrastructureLayer\User\DTO\SavedUserDTO;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class DBManagerWithDoctrine implements StorageManagerInterface
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

        $user = new Users(
            $id,
            $saveUserDTO->login,
            $saveUserDTO->password,
            $saveUserDTO->email,
            $saveUserDTO->phoneNumber,
            $addressId,
            $profileId
        );


        $entityManager->persist($user);
        $entityManager->flush();

        return new SavedUserDTO($id);
    }

    public function saveAddress(SaveAddressDTO $saveAddressDTO): Uuid
    {

        $entityManager = $this->registry->getManagerForClass(Address::class);

        $id = Uuid::v1();
        $address = new Address();
        $address->setId($id);
        $address->setCountry($saveAddressDTO->country);
        $address->setCity($saveAddressDTO->city);
        $address->setStreet($saveAddressDTO->street);
        $address->setHouseNumber($saveAddressDTO->houseNumber);

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

    public function getUser(GetUserDTO $getUserDTO): GotUserDTO
    {
        $entityManager = $this->registry->getManagerForClass(Users::class);
        $userRepository = $entityManager->getRepository(Users::class);

        $user = $userRepository->find($getUserDTO->id);

        return new GotUserDTO(
            $user->getLogin(),
            $user->getPassword(),
            $user->getAge(),
            $user->getEmail(),
            $user->getPhoneNumber()
        );
//        $connection = $this->registry->getConnection();
//        $DBH = $connection->getWrappedConnection();
//
//        if(!$getUserDTO->id){
//            throw new \Exception('Пользователь не найден', 404);
//        }
//
//        $sth = $DBH->prepare("SELECT first_name, last_name, age, email, phone_number FROM users WHERE id = :id;");
//        $sth->execute(['id' => $getUserDTO->id]);
//        $result = $sth->fetch(PDO::PARAM_STR);
//
//        return new GotUserDTO(
//            $result['first_name'],
//            $result['last_name'],
//            $result['age'],
//            $result['email'],
//            $result['phone_number']
//        );
    }

    public function getUsers(): UserDtoCollection
    {
        $entityManager = $this->registry->getManagerForClass(Users::class);
        $userRepository = $entityManager->getRepository(Users::class);
        $users = $userRepository->findAll();
        $data = $this->entityMapper->mapToArray($users);

        $userDTOCollection = $this->collectionMapper->mapFromArray($data);
        return $userDTOCollection;
    }
}