<?php
header('Content-Type: application/json');


$servername = "localhost"; 
$username = "kullanici_adi";
$password = "parolaniz";
$dbname = "veritabani_adi";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['verified' => false, 'message' => 'Veritabanı bağlantısı başarısız: ' . $conn->connect_error]));
}

$sql = "SELECT is_verified, message FROM kyc_status WHERE user_id = ?";


$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die(json_encode(['verified' => false, 'message' => 'Sorgu hazırlanamadı.']));
}


$user_id = 1;
$stmt->bind_param("i", $user_id);


$stmt->execute();


$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = [
        'verified' => $row['is_verified'] == 1,
        'message' => $row['message']
    ];
} else {
    $status = [
        'verified' => false,
        'message' => 'KYC durumu bulunamadı.'
    ];
}


$stmt->close();
$conn->close();


echo json_encode($status);
?>
