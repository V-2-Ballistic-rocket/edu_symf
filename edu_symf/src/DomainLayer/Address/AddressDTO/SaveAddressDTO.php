<?php

namespace App\DomainLayer\Address\AddressDTO;

use Symfony\Component\Uid\Uuid;

readonly class SaveAddressDTO
{
    public function __construct(
        public string $country = '',
        public string $city = '',
        public string $street = '',
        public string $houseNumber = ''
    )
    {}
}