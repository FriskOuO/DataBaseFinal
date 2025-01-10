document.addEventListener("DOMContentLoaded", function() {
    const errors = JSON.parse(document.getElementById('errors-data').textContent);
    const success = JSON.parse(document.getElementById('success-data').textContent);
    const messagesDiv = document.getElementById('messages');

    if (errors.length > 0) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error';
        errors.forEach(error => {
            const p = document.createElement('p');
            p.textContent = error;
            errorDiv.appendChild(p);
        });
        messagesDiv.appendChild(errorDiv);
    }

    if (success) {
        const successDiv = document.createElement('div');
        successDiv.className = 'success';
        const p = document.createElement('p');
        p.textContent = '註冊成功！';
        successDiv.appendChild(p);
        messagesDiv.appendChild(successDiv);
    }
});