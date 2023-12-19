<?php

namespace App\Tests\Domain\Address\Factory;

use App\DomainLayer\Address\Address;
use App\DomainLayer\Address\AddressDTO\CreateAddressDTO;
use App\DomainLayer\Address\Factory\AddressFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressFactoryTest extends TestCase
{
    /**
     * @dataProvider  validDataProvider
     */
    public function testValidate($createAddressDTO): void
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('validate')
            ->with($createAddressDTO);

        $factory = new AddressFactory($validator);
        $actualAddress = $factory->CreateAddress($createAddressDTO);
        $expectedAddress = new Address($createAddressDTO);
        $this->assertEquals($expectedAddress, $actualAddress);
    }

    public function validDataProvider():array
    {
        return [
          [
              'createAddressDTO' => new CreateAddressDTO(
                  'Lapland',
                  'NetherWill',
                  'GreenStreet',
                  '61A'
              )
          ]
        ];
    }
}
