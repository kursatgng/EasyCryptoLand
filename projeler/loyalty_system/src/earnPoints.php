<?php
header('Content-Type: application/json');

// Veritabanı bağlantısı
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
$pointsEarned = 10; 

$sql = 'UPDATE users SET points = points + :pointsEarned WHERE id = :userId';
$stmt = $pdo->prepare($sql);
$stmt->execute(['pointsEarned' => $pointsEarned, 'userId' => $userId]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Puan kazanma işlemi başarısız.']);
}
?>
