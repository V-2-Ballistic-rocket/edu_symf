<?php

namespace App\common\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use UnexpectedValueException;

class ContainStringValidator extends ConstraintValidator
{

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint) : void
    {
        if (null === $value || '' === $value) {
            throw new UnexpectedValueException($value, 'string');
        }
        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }
        if(!preg_match('/^[a-zA-Z]+$/', $value)){
            throw new UnexpectedValueException($value, 'string');
        }
    }
}