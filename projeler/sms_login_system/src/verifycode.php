<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['phone']) && isset($input['code'])) {
    $phone = $input['phone'];
    $code = $input['code'];

    $savedCode = getSavedVerificationCodeFromDatabase($phone);

    if ($savedCode == $code) {
        echo json_encode(['success' => true, 'message' => 'Doğrulama başarılı.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Hatalı doğrulama kodu.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
}

function getSavedVerificationCodeFromDatabase($phoneNumber) {
    // Veritabanına bağlan ve kaydedilmiş kodu getir
    // Bu kısımda kendi veritabanı işlemlerini ekle
}
?>
