<?php
header('Content-Type: application/json');

if (isset($_FILES['document']) && isset($_POST['name']) && isset($_POST['email'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $document = $_FILES['document'];

    // Belgeyi geçici dosya olarak yükleyin
    $tempPath = $document['tmp_name'];

    // 3. parti KYC API entegrasyonu
    $apiUrl = 'https://api.3rdpartykyc.com/verify';
    $apiKey = 'YOUR_API_KEY';
    
    $data = [
        'name' => $name,
        'email' => $email,
        'document' => new CURLFile($tempPath, $document['type'], $document['name'])
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if ($responseData && isset($responseData['success']) && $responseData['success'] === true) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'KYC doğrulaması başarısız oldu.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
}
?>
