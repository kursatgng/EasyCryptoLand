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
$pointsToRedeem = 10; 

$sql = 'UPDATE users SET points = points - :pointsToRedeem WHERE id = :userId AND points >= :pointsToRedeem';
$stmt = $pdo->prepare($sql);
$stmt->execute(['pointsToRedeem' => $pointsToRedeem, 'userId' => $userId]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Puan kullanma işlemi başarısız.']);
}
?>
