<?php

namespace App\common\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ContainAgeValidator extends ConstraintValidator
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
        if (!is_numeric($value)){
            throw new UnexpectedTypeException($constraint, ContainPhoneNumber::class);
        }
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }
        if(intval($value) > 120 || intval($value) < 0){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

    }
}