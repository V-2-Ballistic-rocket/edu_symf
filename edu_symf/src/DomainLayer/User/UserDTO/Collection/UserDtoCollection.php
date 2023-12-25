<?php

namespace App\DomainLayer\User\UserDTO\Collection;

use App\common\Abstract\AbstractCollection;

class UserDtoCollection extends AbstractCollection
{
    public function __construct(UserDTO ...$userDTO)
    {
        $this->collection = $userDTO;
    }

    protected function getClassName(): string
    {
        return UserDTO::class;
    }
}