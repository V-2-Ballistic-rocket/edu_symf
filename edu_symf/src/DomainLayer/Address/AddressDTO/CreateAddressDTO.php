<?php

namespace App\DomainLayer\Address\AddressDTO;
use App\common\Validators as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;
readonly class CreateAddressDTO
{
    public function __construct(
        #[CustomAssert\ContainProperName]
        public string $country = '',
        #[CustomAssert\ContainProperName]
        public string $city = '',
        #[CustomAssert\ContainProperName]
        public string $street = '',
        public string $houseNumber = ''
    )
    {
    }
}