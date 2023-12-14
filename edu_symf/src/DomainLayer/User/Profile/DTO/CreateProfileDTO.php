<?php

namespace App\DomainLayer\User\Profile\DTO;

use App\common\Validators as CustomAssert;

class CreateProfileDTO
{


    public function __construct(
        #[CustomAssert\ContainProperName]
        public string $firstName = '',
        #[CustomAssert\ContainProperName]
        public string $lastName = '',
        #[CustomAssert\ContainAge]
        public int $age = 0,
        public string $toAvatarPath = ''
    )
    {

    }
}