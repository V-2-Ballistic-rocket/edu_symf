<?php

namespace App\InfrastructureLayer\Mailer;

use App\DomainLayer\Mail\DTO\SendConfirmMailDTO;
use App\DomainLayer\Mail\MailManagerInterface;
use App\View\EmailSchema\ConfirmRegistrationByEmailSchema;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailManager implements MailManagerInterface
{
    public function __construct(
        private MailerInterface $mailer
    )
    {
    }

    public function sendConfirmEmail(SendConfirmMailDTO $confirmRegistrationDTO): void
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