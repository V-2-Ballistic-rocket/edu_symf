<?php

namespace App\common\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ContainPhoneNumberValidator extends ConstraintValidator
{

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint) : void
    {
        if (!$constraint instanceof ContainPhoneNumber) {
            throw new UnexpectedTypeException($constraint, ContainPhoneNumber::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }
        if(!preg_match("/^[\+]?\d[\s|\-]?[(]?\d{3}[\)]?[\s|\-]?\d{3}[\s|\-]?\d{2}[\s|\-]?\d{2}$/", $value)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}