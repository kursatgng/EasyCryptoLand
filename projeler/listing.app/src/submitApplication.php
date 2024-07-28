<?php
header('Content-Type: application/json');


$dsn = 'mysql:host=localhost;dbname=your_database_name;charset=utf8';
$username = 'your_database_username';
$password = 'your_database_password';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Veritabanına bağlanırken bir hata oluştu.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['name']) && isset($input['email']) && isset($input['listing'])) {
    $name = $input['name'];
    $email = $input['email'];
    $listing = $input['listing'];

    if (saveApplicationToDatabase($pdo, $name, $email, $listing)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Başvuru kaydedilirken bir hata oluştu.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
}

function saveApplicationToDatabase($pdo, $name, $email, $listing) {
    try {
        $sql = "INSERT INTO applications (name, email, listing) VALUES (:name, :email, :listing)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':listing', $listing);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
       
        return false;
    }
}
?>
