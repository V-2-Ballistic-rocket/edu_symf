<?php

namespace App\Tests\InfrastructureLayer\DBManager;
use App\DomainLayer\User\Registration\DTO\SavedUserDTO;
use App\DomainLayer\User\UserDTO\Collection\UserDtoCollection;
use App\InfrastructureLayer\Entity\Users;
use App\InfrastructureLayer\Postgres\DBManagerWithDoctrine;
use App\InfrastructureLayer\Repository\UsersRepository;
use App\InfrastructureLayer\User\DataMappers\UserCollectionMapper;
use App\InfrastructureLayer\User\DataMappers\UserEntityMapper;
use App\InfrastructureLayer\User\DTO\GetUserDTO;
use App\InfrastructureLayer\User\DTO\GotUserDTO;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class DBManagerWithDoctrineTest extends KernelTestCase
{
    /**
     *@dataProvider saveUserProvider
     */
    public function testSaveUser($firstName, $lastName, $age, $email, $phoneNumber): void
    {
        $saveUserDTO = new PostUserDTO(
            $firstName,
            $lastName,
            $age,
            $email,
            $phoneNumber
        );

        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $managerRegistry->method('getManagerForClass')->willReturn($entityManager);

        $entityManager->expects($this->once())
            ->method('persist');
        $entityManager->expects($this->once())
            ->method('flush');

        $dbManager = new DBManagerWithDoctrine($managerRegistry);

        $savedUserDTO = $dbManager->saveUser($saveUserDTO);
        $this->assertInstanceOf(SavedUserDTO::class, $savedUserDTO);
    }

    public function saveUserProvider() : array
    {
        return [
            'when valid data' =>
                [
                    'firstName' => 'Vasiliy',
                    'lastName' => 'Mahonenko',
                    'age' => 35,
                    'email' => 'v.mahoneko@mail.com',
                    'phoneNumber' => null
                ]
        ];
    }

    /**
     * @dataProvider getUserProvider
     */
    public function testGetUser($id)
    {
        $getUserDTO = new GetUserDTO($id);
        $user = new Users();
        $user->setLogin('John');
        $user->setPassword('Doe12332');
        $user->setAge(25);
        $user->setEmail('johndoe@example.com');
        $user->setPhoneNumber('1234567890');

        $entityManager = $this->createMock(ManagerRegistry::class);
        $userRepository = $this->createMock(UsersRepository::class);

        $entityManager->expects($this->once())
            ->method('getManagerForClass')
            ->with(Users::class)
            ->willReturnSelf();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Users::class)
            ->willReturn($userRepository);
        $userRepository->expects($this->once())
            ->method('find')
            ->with($getUserDTO->id)
            ->willReturn($user);

        $userService = new DBManagerWithDoctrine($entityManager);
        $gotUserDTO = $userService->getUser($getUserDTO);

        $this->assertInstanceOf(GotUserDTO::class, $gotUserDTO);
        $this->assertEquals('John', $gotUserDTO->firstName);
        $this->assertEquals('Doe12332', $gotUserDTO->lastName);
        $this->assertEquals(25, $gotUserDTO->age);
        $this->assertEquals('johndoe@example.com', $gotUserDTO->email);
        $this->assertEquals('1234567890', $gotUserDTO->phoneNumber);
    }
    public function getUserProvider(): array
    {
        return [
            'when the id exists' =>
                [
                    'id' => Uuid::fromString('692736b4-98dd-11ee-b865-ad17de2134c5')
                ]
        ];
    }

    public function testGetUsers()
    {
        // Создание моков и настройка зависимостей
        $entityManager = $this->createMock(ManagerRegistry::class);
        $userRepository = $this->createMock(UsersRepository::class);
        $entityMapper = $this->createMock(UserEntityMapper::class);
        $collectionMapper = $this->createMock(UserCollectionMapper::class);

        // Задание ожидаемых вызовов и возвращаемых значений для моков
        $users = [new Users(), new Users()]; // Пример данных пользователей
        $address = []; // Пример данных адресов
        $profiles = []; // Пример данных профилей
        $data = []; // Пример результата отображения сущностей в массив
        $userDtoCollection = new UserDtoCollection(); // Пример результата отображения массива в коллекцию DTO

        $entityManager->expects($this->once())
            ->method('getManagerForClass')
            ->willReturn($entityManager);

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($userRepository);

        $userRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($users);

        $entityMapper->expects($this->once())
            ->method('mapToArray')
            ->with($users, $profiles, $address)
            ->willReturn($data);

        $collectionMapper->expects($this->once())
            ->method('mapFromArray')
            ->with($data)
            ->willReturn($userDtoCollection);

        // Создание объекта сервиса и вызов тестируемого метода
        $userService = new DBManagerWithDoctrine($entityManager, $collectionMapper, $entityMapper);
        $result = $userService->getUsers();

        // Проверка результата
        $this->assertInstanceOf(UserDtoCollection::class, $result);
    }
}
