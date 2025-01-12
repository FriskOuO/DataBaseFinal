import showUpdatePage from "./showUpdatePage.js";

export default function showUpdateList(){

axios.get("../server/index.php?action=DoSelect")
.then(res => {
    let response = res['data'];
    switch (response['status']) {
        case 200:
            let rows = response['result'];

            let str;
            str = `<table>`;
            str += `<tr><td>     </td><td>姓名</td><td>電話</td><td>電子信箱</td></tr>`;
            rows.forEach(element => {
                str += "<tr>";
                str += "<td>" + `<input type="radio" name="id" value="` + element['member_id'] + `">` + "</td>";
                str += "<td>" + element['member_name'] + "</td>";
                str += "<td>" + element['member_celephone'] + "</td>";
                str += "<td>" + element['member_email'] + "</td>";
                str += "</tr>";
            });
            str += `</table>`;
            str += `<button id="showUpdatePage">修改</button>`;
            document.getElementById('content').innerHTML = str;

            document.getElementById('showUpdatePage').onclick= function(){
                showUpdatePage()
            }
            break;
        default:
            document.getElementById('content').innerHTML = response['message'];
            break;
    }
})
.catch(err => {
    console.error(err); 
});
}
