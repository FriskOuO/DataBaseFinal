document.getElementById('addMovieForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    let data = {
        "movie_id": document.getElementById('movie_id').value,
        "movie_name": document.getElementById('movie_name').value,
        "movie_type": document.getElementById('movie_type').value,
        "movie_lv": document.getElementById('movie_lv').value
    };

    console.log(data);

    axios.post("../../server/php/admin_home.php", Qs.stringify(data))
    .then(res => {
        let response = res['data'];
        if (response.success) {
            alert('電影上架成功!');
        } else {
            alert('電影上架失敗: ' + response.message);
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('電影上架失敗: ' + err);
    });
});