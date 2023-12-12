<?php

namespace App\Tests\Domain\Address\Factory;

use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use App\DomainLayer\Address\Factory\AddressFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressFactoryTest extends TestCase
{
    /**
     * @dataProvider  validDataProvider
     */
    public function testAddressFactory($country, $city, $street, $houseNumber): void
    {
        $createAddressDTO = new CreateAddressDTO($country, $city, $street, $houseNumber);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())->method('validate');
        $addressFactory = new AddressFactory($validator);

        $address = $addressFactory->CreateAddress(new CreateAddressDTO(
            $country,
            $city,
            $street,
            $houseNumber
        ));

            $this->assertEquals(
            array(
                $country,
                $city,
                $street,
                $houseNumber
            ),
            array(
                $address->getCountry(),
                $address->getCity(),
                $address->getStreet(),
                $address->getHouseNumber())
        );
    }
    public function validDataProvider():array
    {
        return [
            'when data is valid' =>
            [
                'country' => 'Lapland',
                'city' => 'NightCity',
                'street' => 'RedLight',
                'houseNumber' => '101'
            ]
        ];
    }
}
