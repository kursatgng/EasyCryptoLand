function submitKYC() {
    const formData = new FormData(document.getElementById('kycForm'));
    const resultDiv = document.getElementById('result');

    fetch('src/processKYC.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.textContent = 'KYC işleminiz başarıyla gönderildi.';
            resultDiv.style.color = 'green';
        } else {
            resultDiv.textContent = 'KYC işlemi gönderilirken bir hata oluştu. Lütfen tekrar deneyin.';
            resultDiv.style.color = 'red';
        }
    })
    .catch(error => {
        resultDiv.textContent = 'Bir hata oluştu. Lütfen tekrar deneyin.';
        resultDiv.style.color = 'red';
        console.error('Error:', error);
    });
}
