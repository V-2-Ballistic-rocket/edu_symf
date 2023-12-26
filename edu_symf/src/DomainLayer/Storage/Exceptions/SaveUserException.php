<?php

namespace App\DomainLayer\Storage\Exceptions;

use App\DomainLayer\Exceptions\DomainException;
use Throwable;

class SaveUserException extends DomainException
{
    public function __construct(
        string $message = "Не удалось сохранить пользователя",
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