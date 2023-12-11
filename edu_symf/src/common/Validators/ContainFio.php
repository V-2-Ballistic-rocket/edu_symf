<?php

namespace App\common\Validators;

use Symfony\Component\Validator\Constraint;
#[\Attribute]
class ContainFio extends Constraint
{
    public $message = 'значение "{{ value }}" указано некорректно';
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