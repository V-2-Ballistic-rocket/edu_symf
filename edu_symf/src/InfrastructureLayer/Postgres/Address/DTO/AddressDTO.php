<?php

namespace App\InfrastructureLayer\Postgres\Address\DTO;

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