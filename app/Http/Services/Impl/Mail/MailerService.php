<?php
namespace App\Http\Services\Impl\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class MailerService
{
    protected PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        // Cấu hình SMTP
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com'; // Thay bằng host SMTP của bạn
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'binhtranquoc2005@gmail.com'; // Thay bằng email của bạn
        $this->mail->Password = 'twdn uzna endc dcaa'; // Thay bằng mật khẩu ứng dụng
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
        $this->mail->CharSet = 'UTF-8';
    }

    public function sendEmail(string $to, string $subject, string $body, array $attachments = []): bool
    {
        try {
            $this->mail->setFrom('binhtranquoc2005@gmail.com', 'Hạt Vàng Organic');
            $this->mail->addAddress($to);

            // Đính kèm file nếu có
            foreach ($attachments as $file) {
                $this->mail->addAttachment($file);
            }

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Lỗi khi gửi email: {$this->mail->ErrorInfo}";
        }
    }
}