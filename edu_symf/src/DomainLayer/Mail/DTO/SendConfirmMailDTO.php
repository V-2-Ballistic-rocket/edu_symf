<?php

namespace App\DomainLayer\Mail\DTO;

readonly class SendConfirmMailDTO
{
    public function __construct(
        public ?string $confirmRegistrationToken = null,
        public string $emailTo = '',
        public string $emailFrom = '',
    )
    {
    }
}