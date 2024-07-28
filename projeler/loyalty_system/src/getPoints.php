<?php
header('Content-Type: application/json');


$dsn = 'mysql:host=localhost;dbname=loyalty_system';
$username = 'root';
$password = '';
$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Veritabanı bağlantısı başarısız.']);
    exit;
}
$userId = 1; 

// Puanları al
$sql = 'SELECT points FROM users WHERE id = :userId';
$stmt = $pdo->prepare($sql);
$stmt->execute(['userId' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode(['success' => true, 'points' => $user['points']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Puanlar alınamadı.']);
}
?>
