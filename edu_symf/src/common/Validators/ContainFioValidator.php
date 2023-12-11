<?php

namespace App\common\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ContainFioValidator extends ConstraintValidator
{

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof ContainPhoneNumber) {
            throw new UnexpectedTypeException($constraint, ContainPhoneNumber::class);
        }
        if (null === $value || '' === $value) {
            throw new UnexpectedTypeException($constraint, ContainPhoneNumber::class);
        }
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }
        if(!preg_match('/\d/', $value)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}