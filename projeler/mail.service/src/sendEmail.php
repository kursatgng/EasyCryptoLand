<?php
header('Content-Type: application/json');
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['email']) && isset($data['subject']) && isset($data['body'])) {
    $email = $data['email'];
    $subject = $data['subject'];
    $body = $data['body'];

    $result = sendMail($email, $subject, $body);

    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz giriş.']);
}
?>
