<?php
header('Content-Type: application/json');
require 'config.php';

$sql = 'SELECT * FROM email_logs ORDER BY sent_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($emails) {
    echo json_encode(['success' => true, 'emails' => $emails]);
} else {
    echo json_encode(['success' => false, 'message' => 'E-posta durumu alınamadı.']);
}
?>
