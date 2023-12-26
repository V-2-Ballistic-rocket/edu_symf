<?php

namespace App\DomainLayer\Mail;

use App\DomainLayer\Mail\DTO\SendConfirmMailDTO;

interface MailManagerInterface
{
    public function sendConfirmEmail(SendConfirmMailDTO $confirmRegistrationDTO): void;
}