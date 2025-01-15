document.getElementById('fetch-movies').addEventListener('click', function() {
    axios.get("../../server/php/get_all_movies.php")
        .then(res => {
            const response = res.data;
            let str;
                    
            if (response.status === 200) {
                const rows = response.result;

                str = "<table>";
                str += "<tr><th>電影ID</th><th>電影類型</th><th>電影名稱</th><th>電影等級</th></tr>";
                rows.forEach(element => {
                    str += "<tr>";
                    str += "<td>" + element.movie_id + "</td>";
                    str += "<td>" + element.movie_type + "</td>";
                    str += "<td>" + element.movie_name + "</td>";
                    str += "<td>" + element.movie_lv + "</td>";
                    str += "</tr>";
                });
                str += "</table>";

            } else {
                str = response.message;
            }
            document.getElementById("movie-list").innerHTML = str;
        })
        .catch(err => {
            document.getElementById("movie-list").innerHTML = '無法獲取電影列表';
            console.error('無法獲取電影列表:', err);
        });
});