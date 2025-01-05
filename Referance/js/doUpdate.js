export default function doupdate(){
    let data = {
        "member_id": document.getElementById("member_id").innerText,
        "member_name": document.getElementById("member_name").value,
        "member_celephone": document.getElementById("member_celephone").value,
        "member_email": document.getElementById("member_email").value,
};
console.log(data);

axios.post("../server/index.php?action=DoUpdate",Qs.stringify(data))
.then(res => {
    // console.log(res);
    
    let response = res['data'];
    let str = response['message'];
    document.getElementById("content").innerHTML = str;
})
.catch(err => {
    document.getElementById("content").innerHTML = err; 
})
}
