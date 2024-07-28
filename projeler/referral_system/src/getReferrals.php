<?php
header('Content-Type: application/json');
require 'config.php';

$sql = 'SELECT name, email FROM referrals';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($referrals) {
    echo json_encode(['success' => true, 'referrals' => $referrals]);
} else {
    echo json_encode(['success' => false, 'message' => 'Referanslar alınamadı.']);
}
?>
