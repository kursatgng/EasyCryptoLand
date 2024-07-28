function processTransaction() {
    const transactionType = document.getElementById('transactionType').value;
    const amount = document.getElementById('amount').value;
    const resultDiv = document.getElementById('result');
    const url = transactionType === 'deposit' ? 'src/deposit.php' : 'src/withdraw.php';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ amount })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.textContent = `İşlem başarılı: ${data.message}`;
            resultDiv.style.color = 'green';
        } else {
            resultDiv.textContent = `İşlem başarısız!: ${data.message}`;
            resultDiv.style.color = 'red';
        }
    })
    .catch(error => {
        resultDiv.textContent = 'Bir hata oluştu. Lütfen tekrar deneyin!!.';
        resultDiv.style.color = 'red';
        console.error('Error:', error);
    });
}
