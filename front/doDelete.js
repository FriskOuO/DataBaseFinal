export default function doDelete(){
    const id = document.getElementsByName("id");
    let idValue;
    for(let i=0; i<id.length; i++){
        if(id[i].checked){
            idValue = id[i].value;
        }
    };
    let data = {
        "member_id":idValue,
    };

    axios.post("../server/index.php?action=DoDelete",Qs.stringify(data))
    .then(res => {
        let response = res['data'];
        content.innerHTML = response['message'];

    })
    .catch(err => {
        console.error(err);
    })
}