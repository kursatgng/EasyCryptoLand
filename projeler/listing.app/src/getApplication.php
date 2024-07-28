<?php
header('Content-Type: application/json');

$host = 'localhost';
$db = 'database_name'; 
$user = 'username'; 
$pass = 'password'; 


$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die(json_encode(['error' => 'Bağlantı hatası: ' . $mysqli->connect_error]));
}

$applications = getApplicationsFromDatabase($mysqli);
echo json_encode(['applications' => $applications]);

function getApplicationsFromDatabase($mysqli) {
    $applications = [];

    $query = "SELECT name, email, listing FROM applications";

    if ($result = $mysqli->query($query)) {
      
        while ($row = $result->fetch_assoc()) {
            $applications[] = $row;
        }
        
        $result->free();
    } else {
      
        return ['error' => 'Sorgu hatası: ' . $mysqli->error];
    }

    $mysqli->close();

    return $applications;
}
?>
