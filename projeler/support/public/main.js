document.addEventListener('DOMContentLoaded', fetchTickets);

function submitTicket() {
    const issue = document.getElementById('issue').value;
    const resultDiv = document.getElementById('result');

    fetch('src/submitTicket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ issue })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.textContent = 'Talebiniz gönderildi. Teşekkürler!';
            resultDiv.style.color = 'green';
            document.getElementById('supportForm').reset();
            fetchTickets(); // Yeni talepleri güncelle
        } else {
            resultDiv.textContent = 'Talep gönderilirken bir hata oluştu. Lütfen tekrar deneyin.';
            resultDiv.style.color = 'red';
        }
    })
    .catch(error => {
        resultDiv.textContent = 'Bir hata oluştu. Lütfen tekrar deneyin.';
        resultDiv.style.color = 'red';
        console.error('Error:', error);
    });
}

function fetchTickets() {
    fetch('src/getTickets.php')
    .then(response => response.json())
    .then(data => {
        const ticketsDiv = document.getElementById('tickets');
        ticketsDiv.innerHTML = '';

        data.tickets.forEach(ticket => {
            const ticketDiv = document.createElement('div');
            ticketDiv.className = 'ticket';
            ticketDiv.textContent = ticket;
            ticketsDiv.appendChild(ticketDiv);
        });
    })
    .catch(error => console.error('Error:', error));
}
