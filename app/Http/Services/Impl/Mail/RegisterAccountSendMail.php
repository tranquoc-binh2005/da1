<?php
namespace App\Http\Services\Impl\Mail;

use App\Http\Services\Impl\Mail\MailerService;
use App\Http\Services\Interfaces\Mail\RegisterAccountSendMailInterface;
class RegisterAccountSendMail extends MailerService implements RegisterAccountSendMailInterface
{
    public function sendMailToClient(string $to, string $subject, string $body, array $attachments = []): bool
    {
        return parent::sendEmail($to, $subject, $body, $attachments);
    }
}