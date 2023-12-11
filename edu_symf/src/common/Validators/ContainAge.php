<?php

namespace App\common\Validators;

use Symfony\Component\Validator\Constraint;
#[\Attribute]
class ContainAge extends Constraint
{
    public $message = 'возраст  "{{ value }}" указан некорректно';

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