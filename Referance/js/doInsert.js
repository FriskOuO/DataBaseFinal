export default function doInsert(){
    let data = {
        "member_id": document.getElementById("member_id").value,
        "member_name": document.getElementById("member_name").value,
        "member_celephone": document.getElementById("member_celephone").value,
        "member_email": document.getElementById("member_email").value,
    };

console.log(data);
    axios.post("../server/index.php?action=DoInsert",Qs.stringify(data)) 
    .then(res => {
        let response = res['data'];
        let str = response['message'];
        document.getElementById("content").innerHTML = str;
    })
    .catch(err => {
        document.getElementById("content").innerHTML = err; 
    })
}    
    