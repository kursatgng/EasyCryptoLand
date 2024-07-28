<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['amount'])) {
    $amount = $input['amount'];
    $userId = getUserId(); // Kullanıcı kimliğini alın (örneğin oturumdan)

    if (withdrawAmount($userId, $amount)) {
        echo json_encode(['success' => true, 'message' => 'Para başarıyla çekildi.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Para çekme işlemi sırasında bir hata oluştu.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
}

function getUserId() {
    // Kullanıcı kimliğini alın (örneğin oturumdan)
    return 1; // Örnek kullanıcı kimliği
}

function withdrawAmount($userId, $amount) {
    try {
        // Veritabanı bağlantısını oluştur
        $db = new PDO('mysql:host=localhost;dbname=deneme_db', 'username', 'password');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // İşlemi başlat
        $db->beginTransaction();
        
        // Kullanıcının mevcut bakiyesini al
        $stmt = $db->prepare('SELECT balance FROM users WHERE id = ? FOR UPDATE');
        $stmt->execute([$userId]);
        $balance = $stmt->fetchColumn();
        
        if ($balance === false) {
            // Kullanıcı bulunamadı
            $db->rollBack();
            return false;
        }

        if ($balance >= $amount) {
            $stmt = $db->prepare('UPDATE users SET balance = balance - ? WHERE id = ?');
            $stmt->execute([$amount, $userId]);
            
            // İşlemi tamamla
            $db->commit();
            return true;
        } else {
            
            $db->rollBack();
            return false;
        }
    } catch (PDOException $e) {
        
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        
        error_log($e->getMessage());
        return false;
    }
}

// Kullanım örneği
$userId = 1; // Çekmek istediğiniz kullanıcı ID'sini belirtin
$amount = 100; // Çekmek istediğiniz miktar
$result = withdrawAmount($userId, $amount);

if ($result) {
    echo "Para çekme işlemi başarılı!";
} else {
    echo "Para çekme işlemi başarısız.";
}

?>


