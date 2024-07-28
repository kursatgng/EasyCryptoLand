<?php
require 'C:\xampp1\htdocs\deneme\twilio-php-main\src\Twilio\autoload.php';

use Twilio\Rest\Client;

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['phone'])) {
    $phone = $input['phone'];
    $account_sid = 'ACd7b98b76470d7e116ce88a1de6405718';
    $auth_token = '6fe46483b6ed30792fb0dd82966d0234';
    $twilio_number = '+12085674107';

    $client = new Client($account_sid, $auth_token);
    $verificationCode = rand(100000, 999999);

    saveVerificationCodeToDatabase($phone, $verificationCode);

    $message = $client->messages->create(
        $phone,
        array(
            'from' => $twilio_number,
            'body' => "Your verification code is: $verificationCode"
        )
    );

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz telefon numarası.']);
}

function saveVerificationCodeToDatabase($phoneNumber, $verificationCode) {
    
}
?>
