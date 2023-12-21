<?php

namespace App\DomainLayer\User\Exceptions;

use App\DomainLayer\Exceptions\DomainException;
use Throwable;

class ConfirmUserException extends DomainException
{
    public function __construct(
        string $message = "Не удалось подтвердить учетную запись пользователя",
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