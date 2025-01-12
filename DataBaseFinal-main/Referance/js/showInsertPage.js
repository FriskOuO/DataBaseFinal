import doInsert from "./doInsert.js";

export default function showInsertPage(){

    const insertPage = `
    會員編號：<input type="text" id="member_id"><br>
    姓名：<input type="text" id="member_name"><br>
    電話：<input type="text" id="member_celephone"><br>
    電子信箱：<input type="text" id="member_email"><br>
    <button id="doinsert">註冊</button>
    `;
    document.getElementById("content").innerHTML = insertPage;

    document.getElementById("doinsert").onclick = function(){
        doInsert();
    };
}    
    