<?php

namespace App\DomainLayer\Mail\Exceptions;

use App\DomainLayer\Exceptions\DomainException;
use Throwable;

class SendMailException extends DomainException
{
    public function __construct(
        string $message = "Не удалось отправить письмо...",
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