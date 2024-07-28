<?php
require 'EmailTemplate.php';

// PHPMailer'i dahil ettim.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Mail sunucusu
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com';
        $mail->Password = 'your_password';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Alıcılar
        $mail->setFrom('from@example.com', 'Meetgate');
        $mail->addAddress($to);

        // İçerik bilgisi
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Örnek kullanımı
$emailTemplate = new EmailTemplate(__DIR__ . '/../templates');
$emailBody = $emailTemplate->render('welcome', [
    // Değişkenleri buraya 
]);

sendEmail('recipient@example.com', 'Hoş Geldiniz', $emailBody);
?>
