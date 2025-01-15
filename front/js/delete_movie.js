// filepath: /d:/Xampp/htdocs/DataBaseFinal/front/js/delete_movie.js
document.addEventListener('DOMContentLoaded', function() {
    function loadMovieList() {
        axios.get('../../server/php/select_movie.php')
            .then(function(response) {
                const movieList = document.getElementById('movie-list');
                let str = `<table>`;
                str += `<tr><td>選擇</td><td>影片名稱</td></tr>`;
                response.data.result.forEach(function(movie) {
                    str += "<tr>";
                    str += `<td><input type="radio" name="movie_id" value="${movie.movie_id}"></td>`;
                    str += `<td>${movie.movie_name}</td>`;
                    str += "</tr>";
                });
                str += `</table>`;
                movieList.innerHTML = str;
            })
            .catch(function(error) {
                console.error('無法獲取影片列表:', error);
            });
    }

    loadMovieList();

    document.getElementById('deleteMovieButton').addEventListener('click', function() {
        const movieIdElements = document.getElementsByName('movie_id');
        let selectedMovieId;
        for (let i = 0; i < movieIdElements.length; i++) {
            if (movieIdElements[i].checked) {
                selectedMovieId = movieIdElements[i].value;
                break;
            }
        }

        if (!selectedMovieId) {
            document.getElementById('response-message').textContent = '請選擇一部影片';
            return;
        }

        const data = { movie_id: selectedMovieId };

        axios.post('../../server/php/delete_movie.php', Qs.stringify(data))
            .then(function(response) {
                document.getElementById('response-message').textContent = response.data.message;
                if (response.data.status === 200) {
                    loadMovieList(); // 刪除成功後刷新影片列表
                }
            })
            .catch(function(error) {
                console.error('刪除影片失敗:', error);
            });
    });
});