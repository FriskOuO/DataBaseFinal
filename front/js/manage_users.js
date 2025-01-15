document.getElementById('fetch-users').addEventListener('click', function() {
    console.log('Fetching users...');
    axios.get("../../server/php/get_users.php")
        .then(res => {
            const response = res.data;
            let str;
                    
            if (response.status === 200) {
                const rows = response.result;
                console.log('Users fetched successfully:', rows);

                str = "<table>";
                str += "<tr><th>會員帳號</th><th>姓名</th><th>電話</th><th>電子信箱</th><th>角色</th></tr>";
                rows.forEach(element => {
                    str += "<tr>";
                    str += `<td>${element.member_account}</td>`;
                    str += `<td>${element.member_name}</td>`;
                    str += `<td>${element.member_celephone}</td>`;
                    str += `<td>${element.member_email}</td>`;
                    str += `<td>${element.member_role}</td>`;
                    str += "</tr>";
                });
                str += "</table>";

            } else {
                str = response.message;
                console.log('Error fetching users:', str);
            }
            document.getElementById("user-list").innerHTML = str;
        })
        .catch(err => {
            document.getElementById("user-list").innerHTML = '無法獲取使用者列表';
            console.error('Error fetching users:', err);
        });
});

document.getElementById('delete-users').addEventListener('click', function(event) {
    event.preventDefault();
    console.log('Fetching users for deletion...');
    axios.get("../../server/php/get_users.php")
        .then(res => {
            const response = res.data;
            let str;
                    
            if (response.status === 200) {
                const rows = response.result;
                console.log('Users fetched for deletion:', rows);

                str = "<form id='user-selection-form'>";
                str += "<table>";
                str += "<tr><th>選擇</th><th>會員帳號</th><th>姓名</th><th>電話</th><th>電子信箱</th><th>角色</th></tr>";
                rows.forEach(element => {
                    str += "<tr>";
                    str += `<td><input type="radio" name="selected-user" value="${element.member_account}"></td>`;
                    str += `<td>${element.member_account}</td>`;
                    str += `<td>${element.member_name}</td>`;
                    str += `<td>${element.member_celephone}</td>`;
                    str += `<td>${element.member_email}</td>`;
                    str += `<td>${element.member_role}</td>`;
                    str += "</tr>";
                });
                str += "</table>";
                str += "</form>";

            } else {
                str = response.message;
                console.log('Error fetching users for deletion:', str);
            }
            document.getElementById("user-list").innerHTML = str;
            document.getElementById('delete-user-form').style.display = 'block';
        })
        .catch(err => {
            document.getElementById("user-list").innerHTML = '無法獲取使用者列表';
            console.error('Error fetching users for deletion:', err);
        });
});

document.getElementById('delete-user-form').addEventListener('submit', function(event) {
    event.preventDefault();
    console.log('Submitting delete user form...');
    const selectedUser = document.querySelector('input[name="selected-user"]:checked');
    if (selectedUser) {
        const member_account = selectedUser.value;
        console.log('Selected user account for deletion:', member_account);
        axios.post('../../server/php/manage_users_delete.php', Qs.stringify({ member_account: member_account }))
            .then(function (response) {
                console.log('Delete user response:', response.data);
                document.getElementById('response-message').innerText = response.data.message;
                if (response.data.status === 200) {
                    document.getElementById('delete-users').click(); // Refresh the user list
                }
            })
            .catch(function (error) {
                console.error('Error deleting user:', error);
                document.getElementById('response-message').innerText = '刪除使用者時發生錯誤';
            });
    } else {
        console.log('No user selected for deletion');
        document.getElementById('response-message').innerText = '請選擇一個使用者';
    }
});