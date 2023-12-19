<?php

namespace App\DomainLayer\Address\Exceptions;

use App\DomainLayer\Exceptions\DomainException;
use Throwable;

class AddressException extends DomainException
{
    public function __construct(string $message = "Адрес введён некорректно.", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }}