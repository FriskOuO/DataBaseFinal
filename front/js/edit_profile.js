function editProfile() {
    let data = {
        "member_account": document.getElementById("member_account").value,
        "member_name": document.getElementById("member_name").value,
        "member_celephone": document.getElementById("member_celephone").value,
        "member_email": document.getElementById("member_email").value,
    };
    
    console.log("Sending data:", data);

    axios.post("../../server/php/edit_profile.php", Qs.stringify(data))
        .then(res => {
            let response = res.data;
            console.log("Response received:", response);
            let str = response.message;
            document.getElementById("content").innerHTML = str;
        })
        .catch(err => {
            console.error('更新資料時發生錯誤:', err);
            document.getElementById("content").innerHTML = '更新資料時發生錯誤';
        });
}

// 確保函數在全域範圍內可用
window.editProfile = editProfile;