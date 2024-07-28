document.addEventListener('DOMContentLoaded', () => {
    fetchPoints();
});

function fetchPoints() {
    fetch('src/getPoints.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('points').textContent = data.points;
        } else {
            alert('Puanlar yüklenemedi.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function earnPoints() {
    fetch('src/earnPoints.php', { method: 'POST' })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchPoints();
        } else {
            alert('Puan kazanma işlemi başarısız.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function redeemPoints() {
    fetch('src/redeemPoints.php', { method: 'POST' })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchPoints();
        } else {
            alert('Puan kullanma işlemi başarısız.');
        }
    })
    .catch(error => console.error('Error:', error));
}
