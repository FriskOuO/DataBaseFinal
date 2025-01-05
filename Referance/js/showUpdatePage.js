import doUpdate from "./doUpdate.js";

export default function showUpdatePage(){
    const id = document.getElementsByName("member_id");
                let idValue;
                for(let i=0; i<id.length; i++){
                    if(id[i].checked){
                        idValue = id[i].value;
                    }
                };
                let data = {
                    "member_id": idValue,
                };

                axios.post("../server/index.php?action=DoSelect",Qs.stringify(data))
                .then(res => {
                    let response = res['data'];
                    const row = response['result'][0];
                    const updatePage = `
                        會員編號：<div id="member_id">` + row['member_id'] + `</div><br>   
                        姓名：<input type="text" id="member_name" value="` + row['member_name'] + `"><br>
                        電話：<input type="text" id="member_celephone" value="` + row['member_celephone'] + `"><br>
                        電子信箱：<input type="text" id="member_email" value="` + row['member_email'] + `"><br>
                        <button id="doupdate">更新</button> 
                    `;
                    document.getElementById("content").innerHTML = updatePage;

                    document.getElementById("doupdate").onclick = function(){
                        doUpdate()
                    }
                })
                .catch(err => {
                    console.error(err); 
                });
}