document.addEventListener('DOMContentLoaded', fetchApplications);

function submitApplication() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const listing = document.getElementById('listing').value;
    const resultDiv = document.getElementById('result');

    fetch('src/submitApplication.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name, email, listing })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.textContent = 'Başvurunuz gönderildi. Teşekkürler!';
            resultDiv.style.color = 'green';
            document.getElementById('applicationForm').reset();
            fetchApplications(); // Yeni başvuruları güncelleme
        } else {
            resultDiv.textContent = 'Başvuru gönderilirken bir hata oluştu. Lütfen tekrar deneyin.';
            resultDiv.style.color = 'red';
        }
    })
    .catch(error => {
        resultDiv.textContent = 'Bir hata oluştu. Lütfen tekrar deneyin.';
        resultDiv.style.color = 'red';
        console.error('Error:', error);
    });
}

function fetchApplications() {
    fetch('src/getApplications.php')
    .then(response => response.json())
    .then(data => {
        const applicationsDiv = document.getElementById('applications');
        applicationsDiv.innerHTML = '';

        data.applications.forEach(application => {
            const applicationDiv = document.createElement('div');
            applicationDiv.className = 'application';
            applicationDiv.innerHTML = `<strong>Ad:</strong> ${application.name}<br>
                                        <strong>E-posta:</strong> ${application.email}<br>
                                        <strong>Listeleme:</strong> ${application.listing}`;
            applicationsDiv.appendChild(applicationDiv);
        });
    })
    .catch(error => console.error('Error:', error));
}
