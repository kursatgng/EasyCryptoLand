document.addEventListener('DOMContentLoaded', fetchSuggestions);

function submitSuggestion() {
    const suggestion = document.getElementById('featureSuggestion').value;
    const resultDiv = document.getElementById('result');

    fetch('src/submitFeedback.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ suggestion })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.textContent = 'Öneriniz gönderildi. Teşekkürler!';
            resultDiv.style.color = 'green';
            document.getElementById('featureForm').reset();
            fetchSuggestions(); // Yeni önerileri güncelle
        } else {
            resultDiv.textContent = 'Öneri gönderilirken bir hata oluştu. Lütfen tekrar deneyin.';
            resultDiv.style.color = 'red';
        }
    })
    .catch(error => {
        resultDiv.textContent = 'Bir hata oluştu. Lütfen tekrar deneyin.';
        resultDiv.style.color = 'red';
        console.error('Error:', error);
    });
}

function fetchSuggestions() {
    fetch('src/getUserSuggestions.php')
    .then(response => response.json())
    .then(data => {
        const suggestionsDiv = document.getElementById('suggestions');
        suggestionsDiv.innerHTML = '';

        data.suggestions.forEach(suggestion => {
            const suggestionDiv = document.createElement('div');
            suggestionDiv.className = 'suggestion';
            suggestionDiv.textContent = suggestion;
            suggestionsDiv.appendChild(suggestionDiv);
        });
    })
    .catch(error => console.error('Error:', error));
}
