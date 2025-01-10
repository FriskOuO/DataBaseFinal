document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    
    // 假設驗證成功
    if (username === 'user' && password === 'password') {
        window.location.href = 'html/home.html'; // 修改路徑以確保正確導向
    } else {
        alert('登入失敗');
    }
    
    // 可以在這裡添加一些前端驗證邏輯
});