<?php
header('Content-Type: application/json');

$tickets = getTicketsFromDatabase();
echo json_encode(['tickets' => $tickets]);

function getTicketsFromDatabase() {
  
    $servername = "localhost"; // Sunucu adı
    $username = "kullanici_adiniz"; // Kullanıcı adı
    $password = "sifreniz"; // Şifre
    $dbname = "veritabani_adi"; // Veritabanı adı

    // MySQLi ile veritabanına bağlan
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    
    $sql = "SELECT ticket FROM tickets"; // 'tickets' tablosunda 'ticket' sütununu seç
    $result = $conn->query($sql);

    $tickets = [];
    
    if ($result->num_rows > 0) {
        // Verileri oku ve diziye ekle
        while($row = $result->fetch_assoc()) {
            $tickets[] = $row['ticket'];
        }
    } else {
        echo "0 sonuç";
    }

    // Bağlantıyı kapat
    $conn->close();

    return $tickets;
}
?>
