<?php

namespace App\InfrastructureLayer\Mailer;

use App\InfrastructureLayer\Mailer\DTO\ConfirmRegistrationDTO;
use App\View\EmailSchema\ConfirmRegistrationByEmailSchema;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class MailManager
{
    public function __construct(
        private ?Mailer $mailer = null
    )
    {
    }

    public function sendConfirmEmail(ConfirmRegistrationDTO $confirmRegistrationDTO): void
    {

        $schemer = new ConfirmRegistrationByEmailSchema();

        $getMessageDTO = $schemer->getMessage((string)$confirmRegistrationDTO->confirmRegistrationToken);
        $emailFrom = $confirmRegistrationDTO->emailFrom;
        if($confirmRegistrationDTO->emailFrom === '')
        {
            $emailFrom = 'support@example.com';
        }
        $email = (new Email())
            ->from($emailFrom)
            ->to($confirmRegistrationDTO->emailTo)
            ->text($getMessageDTO->text)
            ->html($getMessageDTO->html);

        $this->mailer->send($email);
    }
}