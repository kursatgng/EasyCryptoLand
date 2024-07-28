<?php
$dsn = 'mysql:host=localhost;dbname=referral_system';
$username = 'root';
$password = '';
$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Veritabanı bağlantısı başarısız.']);
    exit;
}
?>
