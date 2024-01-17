<?php

namespace App\Tests\test\Unit\common\Validators;

use App\common\Validators\ContainAge;
use App\common\Validators\ContainAgeValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ContainAgeValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ContainAgeValidator
    {
        return new ContainAgeValidator();
    }

    /**
     * @dataProvider provideInvalidAge
     */
    public function testInvalidDataValidation($age)
    {
        $constraint = new ContainAge();
        $this->validator->validate($age, $constraint);

        $this->buildViolation('возраст  "{{ value }}" указан некорректно')
            ->setParameter('{{ value }}', $age)
            ->assertRaised();
    }

    public function provideInvalidAge(): array
    {
        return [
            [
                4100
            ],
            [
                -1
            ],
            [
                0
            ],
            [
                150
            ],
            [
                121
            ]
        ];
    }

    /**
     * @dataProvider provideValidAge
     */
    public function testValidDataValidation($age)
    {
        $constraint = new ContainAge();
        $this->validator->validate($age, $constraint);

        $this->assertNoViolation();
    }

    public function provideValidAge(): array
    {
        return [
            [
                1
            ],
            [
                18
            ],
            [
                66
            ],
            [
                100
            ],
            [
                120
            ]
        ];
    }

    /**
     * @dataProvider provideInvalidExceptionAge
     */
    public function testInvalidExceptionValidation($age)
    {
        $this->expectException(UnexpectedTypeException::class);

        $constraint = new ContainAge();
        $this->validator->validate($age, $constraint);
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
                'o'
            ],
            [
                'ten'
            ],
            [
                '10F'
            ]
        ];
    }
}