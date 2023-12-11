<?php

namespace App\DomainLayer\Address\Factory;

use App\common\Validators\ContainProperName;
use App\common\Validators\ContainProperNameValidator;
use App\DomainLayer\Address\Address;
use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use PHPUnit\Framework\Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressFactory
{
    public function __construct(
        private readonly ValidatorInterface $validator
    )
    {
    }

    public function CreateAddress(CreateAddressDTO $createAddressDTO): Address
    {
        $violations = $this->validator->validate($createAddressDTO);
        if(count($violations) > 0){
            throw new Exception($violations, 400);
        }
        return new Address($createAddressDTO);
    }
}