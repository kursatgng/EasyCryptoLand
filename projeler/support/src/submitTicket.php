<?php
header('Content-Type: application/json');


$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['issue'])) {
    $issue = $input['issue'];

    if (saveTicketToDatabase($issue)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Talep kaydedilirken bir hata oluştu.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
}

function saveTicketToDatabase($issue) {

    $servername = "localhost"; // Sunucu adı
    $username = "kullanici_adiniz"; // Kullanıcı adı
    $password = "sifreniz"; // Şifre
    $dbname = "veritabani_adiniz"; // Veritabanı adı

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        return false; // Bağlantı hatası
    }

    // SQL
    $stmt = $conn->prepare("INSERT INTO tickets (issue) VALUES (?)");
    if (!$stmt) {
        $conn->close();
        return false; // Prepare hatası
    }

    $stmt->bind_param("s", $issue);
    $success = $stmt->execute();

    // Bağlantıyı kapat
    $stmt->close();
    $conn->close();

    return $success;
}
?>
