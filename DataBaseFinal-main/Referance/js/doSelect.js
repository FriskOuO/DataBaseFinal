export default function doSelect(){
    axios.get("../server/index.php?action=DoSelect")

        .then(res => {
            const response = res['data'];  
            let str;

            
            if (response['status'] == 200){
                const rows=response['result'];

                str = "<table>";
                str += "<tr><td>會員編號</td><td>姓名</td><td>電話</td><td>電子信箱</td></tr>";
                rows.forEach(element => {
                    str += "<tr>";
                    str += "<td>" + element['member_id'] + "</td>";
                    str += "<td>" + element['member_name'] + "</td>";
                    str += "<td>" + element['member_celephone'] + "</td>";
                    str += "<td>" + element['member_email'] + "</td>";
                    str += "</tr>";
                });
                str += "</table>";

            }else{
                str = response['message'];
            }
            document.getElementById("content").innerHTML = str;
        })

        .catch(err => {
            document.getElementById("content").innerHTML = err;
        })
}