document.addEventListener('DOMContentLoaded', function() {
    axios.get('/server/php/user_list.php') // 確保這裡的 PHP 文件路徑正確
        .then(response => {
            const data = response.data;
            if (data.error) {
                throw new Error(data.error);
            }
            let userTable = '<table><tr><th>帳號</th><th>姓名</th><th>手機</th><th>電子郵件</th><th>角色</th></tr>';
            data.forEach(user => {
                userTable += `<tr>
                    <td>${user.member_account}</td>
                    <td>${user.member_name}</td>
                    <td>${user.member_celephone}</td>
                    <td>${user.member_email}</td>
                    <td>${user.member_role}</td>
                </tr>`;
            });
            userTable += '</table>';
            document.getElementById('user-list').innerHTML = userTable;
        })
        .catch(error => console.error('Error:', error));
});