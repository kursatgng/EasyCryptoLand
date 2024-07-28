document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('emailForm').addEventListener('submit', function(event) {
        event.preventDefault();
        sendEmail();
    });
});

function sendEmail() {
    const email = document.getElementById('recipientEmail').value;
    const subject = document.getElementById('emailSubject').value;
    const body = document.getElementById('emailBody').value;

    fetch('src/sendEmail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, subject, body }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('E-posta başarıyla gönderildi.');
        } else {
            alert('E-posta gönderme işlemi başarısız.');
        }
    })
    .catch(error => console.error('Error:', error));
}
