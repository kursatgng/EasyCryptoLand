function sendCode() {
    const phone = document.getElementById('phone').value;

    fetch('../src/sendCode.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ phone })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('phoneForm').style.display = 'none';
            document.getElementById('verificationForm').style.display = 'block';
        } else {
            alert('Bir hata oluştu. Lütfen tekrar deneyin.');
        }
    });
}

function verifyCode() {
    const phone = document.getElementById('phone').value;
    const code = document.getElementById('code').value;

    fetch('../src/verifyCode.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ phone, code })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Giriş başarılı!');
        } else {
            alert('Hatalı doğrulama kodu. Lütfen tekrar deneyin.');
        }
    });
}
