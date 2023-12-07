<?php

namespace App\common\Validators;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ContainString extends Constraint
{
    #[HasNamedArguments]
    public function __construct(
        array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct([], $groups, $payload);
    }

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}