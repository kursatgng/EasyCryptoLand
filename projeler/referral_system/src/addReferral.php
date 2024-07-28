<?php
header('Content-Type: application/json');
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name']) && isset($data['email'])) {
    $name = $data['name'];
    $email = $data['email'];

    $sql = 'INSERT INTO referrals (name, email) VALUES (:name, :email)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'email' => $email]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Referans ekleme işlemi başarısız.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz giriş.']);
}
?>
