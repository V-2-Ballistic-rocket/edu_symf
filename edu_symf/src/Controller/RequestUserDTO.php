<?php

namespace App\Controller;

use App\common\Validators as CustomValidator;
class RequestUserDTO
{
    public function __construct(
        #[CustomValidator\ContainString]
        public mixed $firstName,
        #[CustomValidator\ContainString]
        public mixed $lastName
    )
    {

    }
}