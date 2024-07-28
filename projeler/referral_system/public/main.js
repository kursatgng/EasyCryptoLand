document.addEventListener('DOMContentLoaded', () => {
    fetchReferrals();

    document.getElementById('referralForm').addEventListener('submit', function(event) {
        event.preventDefault();
        addReferral();
    });
});

function fetchReferrals() {
    fetch('src/getReferrals.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const referralList = document.getElementById('referralList');
            referralList.innerHTML = '';
            data.referrals.forEach(referral => {
                const li = document.createElement('li');
                li.textContent = `${referral.name} - ${referral.email}`;
                referralList.appendChild(li);
            });
        } else {
            alert('Referanslar yüklenemedi.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function addReferral() {
    const name = document.getElementById('referralName').value;
    const email = document.getElementById('referralEmail').value;

    fetch('src/addReferral.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name, email }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchReferrals();
            document.getElementById('referralForm').reset();
        } else {
            alert('Referans ekleme işlemi başarısız.');
        }
    })
    .catch(error => console.error('Error:', error));
}
