<?php

namespace App\DomainLayer\User\UserDTO\Collection;

use App\DomainLayer\User\UserDTO\Collection;

interface UserCollectionDtoMapperInterface
{
    public function mapFromArray(array $data): UserDtoCollection;
    public function mapToArray(UserDtoCollection $userDtoCollection): array;
    public function mapToJson(UserDtoCollection $userDtoCollection): string;
}