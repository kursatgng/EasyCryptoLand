<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['suggestion'])) {
    $suggestion = $input['suggestion'];

    if (saveSuggestionToDatabase($suggestion)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Öneri kaydedilirken bir hata oluştu.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
}


    function saveSuggestionToDatabase($suggestion) {
        // Veritabanı bağlantı bilgilerini tanımlayın
        $servername = "Sunucu"; 
        $username = "kullanıcıadı"; 
        $password = "****"; 
        $dbname = "deneme1_db"; 
    
        // Veritabanına bağlan
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Bağlantıyı kontrol et
        if ($conn->connect_error) {
            die("Bağlantı başarısız: " . $conn->connect_error);
        }
    
        // Öneriyi veritabanına ekle
        $stmt = $conn->prepare("INSERT INTO suggestions (suggestion) VALUES (?)");
        $stmt->bind_param("s", $suggestion);
    
        // Sorguyu çalıştır
        if ($stmt->execute()) {
            $result = true;
        } else {
            $result = false;
        }
    
        // Bağlantıyı kapat
        $stmt->close();
        $conn->close();
    
        return $result;
    }
    
    ?>
