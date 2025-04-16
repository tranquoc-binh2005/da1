<?php
namespace App\Http\Services\Impl\Mail;

use App\Http\Services\Impl\Mail\MailerService;
use App\Http\Services\Interfaces\Mail\SendMailInvoiceServiceInterface;
class SendMailInvoiceService extends MailerService implements SendMailInvoiceServiceInterface
{
    public function sendInvoiceToClient(string $to, string $subject, string $body, array $attachments = []): bool
    {
        return parent::sendEmail($to, $subject, $body, $attachments);
    }
}