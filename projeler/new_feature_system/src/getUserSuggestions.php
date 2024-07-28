<?php
header('Content-Type: application/json');

$host = 'localhost'; 
$dbname = 'veritabani_adiniz';
$user = 'kullanici_adiniz';
$pass = 'sifreniz';


$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

$suggestions = getSuggestionsFromDatabase($pdo);
echo json_encode(['suggestions' => $suggestions]);

function getSuggestionsFromDatabase($pdo) {
    // Veritabanından önerileri çek
    $sql = "SELECT denem2 FROM deneme2_table"; 
    $stmt = $pdo->query($sql);

    // Sonuçları al ve döndür
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>
