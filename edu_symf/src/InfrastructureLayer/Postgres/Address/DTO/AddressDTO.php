<?php

namespace App\InfrastructureLayer\Address\DTO;

use Symfony\Component\Uid\Uuid;

readonly class AddressDTO
{
    public function __construct(
        public string $country = '',
        public string $city = '',
        public string $street = '',
        public string $houseNumber = ''
    )
    {}
}