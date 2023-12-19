<?php

namespace App\common\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ContainProperNameValidator extends ConstraintValidator
{

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof ContainProperName) {
            throw new UnexpectedTypeException($constraint, ContainProperName::class);
        }
        if (null === $value || '' === $value) {
            throw new UnexpectedTypeException($constraint, ContainProperName::class);
        }
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }
        if(preg_match('/\d/', $value)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}