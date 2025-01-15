function doSelect() {
    axios.get("../../server/php/get_users.php")
        .then(res => {
            const response = res.data;
            let str;
                    
            if (response.status === 200) {
                const rows = response.result;

                str = "<table>";
                str += "<tr><th>會員帳號</th><th>姓名</th><th>電話</th><th>電子信箱</th></tr>";
                rows.forEach(element => {
                    str += "<tr>";
                    str += "<td>" + element.member_account + "</td>";
                    str += "<td>" + element.member_name + "</td>";
                    str += "<td>" + element.member_celephone + "</td>";
                    str += "<td>" + element.member_email + "</td>";
                    str += "</tr>";
                });
                str += "</table>";

            } else {
                str = response.message;
            }
            document.getElementById("user-list").innerHTML = str;
        })
        .catch(err => {
            document.getElementById("user-list").innerHTML = '無法獲取使用者列表';
            console.error('無法獲取使用者列表:', err);
        });
}

document.getElementById('fetch-users').addEventListener('click', doSelect);