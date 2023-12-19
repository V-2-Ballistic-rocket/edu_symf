<?php

namespace App\Tests\common\Validators;

use App\common\Validators\ContainProperName;
use App\common\Validators\ContainProperNameValidator;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ContainProperNameValidatorTest extends ConstraintValidatorTestCase
{

    /**
     * @inheritDoc
     */
    protected function createValidator(): ContainProperNameValidator
    {
        return new ContainProperNameValidator();
    }

    /**
     * @dataProvider provideInvalidProperName
     */
    public function testInvalidDataValidation($properName): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $constraint = new ContainProperName();
        $this->validator->validate($properName, $constraint);
    }

    public function provideInvalidProperName(): array
    {
        return [
            [
                4100
            ],
            [
                null
            ],
            [
                Uuid::v1()
            ],
            [
                3,14
            ],
            [
                true
            ],
            [
                ''
            ]
        ];
    }
    /**
     * @dataProvider provideValidProperName
     */
    public function testValidDataValidation($properName): void
    {
        $constraint = new ContainProperName();
        $this->validator->validate($properName, $constraint);
        $this->assertNoViolation();
    }

    public function provideValidProperName(): array
    {
        return [
            [
                'Mihail'
            ],
            [
                'Palich'
            ],
            [
                'Teryentiev'
            ],
            [
                'Boston'
            ],
            [
                'True'
            ]
        ];
    }

    /**
     * @dataProvider provideTestBuildViolation
     */
    public function testBuildViolationValidation($properName): void
    {
        $constraint = new ContainProperName();
        $this->validator->validate($properName, $constraint);
        $this->buildViolation('значение "{{ value }}" указано некорректно')
            ->setParameter('{{ value }}', $properName)
            ->assertRaised();
    }
    public function provideTestBuildViolation(): array
    {
        return [
            [
                'F4uDv4'
            ],
            [
                'aaaaaaaaaaaaaa1'
            ],
            [
                'Teryent1ev'
            ],
            [
                'B0ston'
            ]
        ];
    }
}