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
    public function testSomething($country, $city, $street, $houseNumber): void
    {
        $createAddressDTO = new CreateAddressDTO($country, $city, $street, $houseNumber);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())->method('validate');
        $address = $addressFactory = new AddressFactory($validator);
        $this->assertEquals(
            array($country, $city, $street, $houseNumber),
            array($address->get)
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
