<?php

namespace App\InfrastructureLayer\Mailer\DTO;

use Symfony\Component\Uid\Uuid;

readonly class ConfirmRegistrationDTO
{
    public function __construct(
        public ?string $confirmRegistrationToken = null,
        public string $emailTo = '',
        public string $emailFrom = '',
    )
    {
    }
}