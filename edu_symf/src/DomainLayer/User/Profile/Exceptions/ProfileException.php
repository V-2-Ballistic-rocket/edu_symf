<?php

namespace App\DomainLayer\User\Profile\Exceptions;

use App\DomainLayer\Exceptions\DomainException;
use Throwable;

class ProfileException extends DomainException
{
    public function __construct(
        string $message = "Данные профиля введены некорректно",
        int $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}