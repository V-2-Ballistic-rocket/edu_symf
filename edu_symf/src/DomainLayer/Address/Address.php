<?php

namespace App\DomainLayer\Address;

use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;

class Address
{
    private string $country = '';
    private string $city = '';
    private string $street = '';
    private string $houseNumber = '';
    public function __construct(CreateAddressDTO $createAddressDTO)
    {
        $this->country = $createAddressDTO->country;
        $this->city = $createAddressDTO->city;
        $this->street = $createAddressDTO->street;
        $this->houseNumber = $createAddressDTO->houseNumber;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }
}