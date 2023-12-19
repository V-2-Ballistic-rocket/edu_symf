<?php

namespace App\DomainLayer\Address\AddressDTO;

use Symfony\Component\Uid\Uuid;

class AddressDTO
{
    public function __construct(
        public string|null|Uuid $id = null,
        public string $country = '',
        public string $city = '',
        public string $street = '',
        public string $houseNumber = ''
    )
    {
    }
}