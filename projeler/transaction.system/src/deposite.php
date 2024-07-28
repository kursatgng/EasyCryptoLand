<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['amount'])) {
    $amount = $input['amount'];
    $userId = getUserId(); 

    if (depositAmount($userId, $amount)) {
        echo json_encode(['success' => true, 'message' => 'Para başarıyla yatırıldı.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Para yatırma işlemi sırasında bir hata oluştu.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
}

function getUserId() {
    
    return 1; 
}

 
    function depositAmount($userId, $amount) {
        try {
            // Veritabanı bağlantısını oluştur
            $db = new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // İşlemi başlat
            $db->beginTransaction();
            
            // Kullanıcının mevcut bakiyesini güncelle
            $stmt = $db->prepare('UPDATE users SET balance = balance + ? WHERE id = ?');
            $result = $stmt->execute([$amount, $userId]);
            
            // İşlemi tamamla
            if ($result) {
                $db->commit();
                return true;
            } else {
                $db->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            // Hata durumunda işlemi geri al
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            // Hata mesajını günlüğe kaydedin 
            error_log($e->getMessage());
            return false;
        }
    }
    
    
    $userId = 1; // kullanıcı ID'si
    $amount = 100; // Yatırmak istediğiniz miktar
    $result = depositAmount($userId, $amount);
    
    if ($result) {
        echo "Para yatırma işlemi başarılı!";
    } else {
        echo "Para yatırma işlemi başarısız.";
    }
    
    ?>
    
