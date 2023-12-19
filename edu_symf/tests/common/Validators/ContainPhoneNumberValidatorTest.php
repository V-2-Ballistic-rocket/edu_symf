<?php

namespace App\Tests\common\Validators;

use App\common\Validators\ContainPhoneNumber;
use App\common\Validators\ContainPhoneNumberValidator;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ContainPhoneNumberValidatorTest extends ConstraintValidatorTestCase
{

    /**
     * @inheritDoc
     */
    protected function createValidator(): ContainPhoneNumberValidator
    {
        return new ContainPhoneNumberValidator();
    }
    /**
     * @dataProvider phoneNumberProvider
     */
    public function testValidPhoneNumber($phoneNumber): void
    {
        $constraint = new ContainPhoneNumber();
        $this->validator->validate($phoneNumber, $constraint);

        $this->assertNoViolation();
    }

    public function phoneNumberProvider(): array
    {
        return [
            [
                '+1 123-456-78-90'
            ],[
                '+77 800 555 35 35'
            ],[
                '+777 800 555 35 35'
            ],[
                '8 800 555 35 35'
            ],[
                '8-(800)-555-35-35'
            ],[
                '+8-(800)-555-35-35'
            ],[
                '+88-(800)-555-35-35'
            ],[
                '+888-(800)-555-35-35'
            ],[
                '+000-(000)-000-00-00'
            ],[
                '8-800-555-35-35'
            ],[
                '+8-800-555-35-35'
            ],
        ];
    }

    /**
     * @dataProvider provideInvalidExceptionAge
     */
    public function testInvalidExceptionValidation($phoneNumber)
    {
        $this->expectException(UnexpectedTypeException::class);

        $constraint = new ContainPhoneNumber();
        $this->validator->validate($phoneNumber, $constraint);
    }

    public function provideInvalidExceptionAge(): array
    {
        return [
            [
                null
            ],
            [
                ''
            ],
            [
                88005553535
            ],
            [
                true
            ],
            [
                Uuid::v1()
            ]
        ];
    }

    /**
     * @dataProvider provideInvalidAge
     */
    public function testInvalidValidation($phoneNumber)
    {
        $constraint = new ContainPhoneNumber();
        $this->validator->validate($phoneNumber, $constraint);

        $this->buildViolation('Номер  "{{ value }}" указан некорректно')
            ->setParameter('{{ value }}', $phoneNumber)
            ->assertRaised();
    }

    public function provideInvalidAge(): array
    {
        return [
            [
                'null'
            ],[
                '88005553030A'
            ],[
                '+7-(111)-A1-33'
            ],[
                '++7-(111)-11-11'
            ],[
                '+7-(111)-11--11'
            ],[
                '+7-(111)--11-11'
            ],[
                '+7--(111)-11-11'
            ],[
                '++7 (111) 11 11'
            ],[
                '++7 111 11 11'
            ],[
                '+7  111 11 11'
            ],[
                '+7 111  11 11'
            ],[
                '+7 111 11  11'
            ],[
                '+7-(111)-11--11'
            ],[
                '+7-(111)--11-11'
            ],[
                '+7--(111)-11-11'
            ],[
                'Uuid::v1()'
            ]
        ];
    }
}