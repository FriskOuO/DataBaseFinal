// 表單提交處理
document.getElementById('addMovieForm').addEventListener('submit', function(event) {
    event.preventDefault(); // 防止表單默認提交行為

    const movie_id = document.getElementById('movie_id').value;
    const movie_type = document.getElementById('movie_type').value;
    const movie_name = document.getElementById('movie_name').value;
    const movie_lv = document.getElementById('movie_lv').value;

    axios.post('/server/php/admin_home.php', {
        movie_id: movie_id,
        movie_type: movie_type,
        movie_name: movie_name,
        movie_lv: movie_lv
    })
    .then(function(response) {
        if (response.data.success) {
            alert('電影新增成功');
            loadMovies(); // 重新載入電影列表
        } else {
            alert('新增失敗: ' + response.data.message);
        }
    })
    .catch(function(error) {
        console.error('新增失敗:', error);
        alert('新增失敗，請檢查控制台錯誤訊息');
    });
});

// 載入電影列表
function loadMovies() {
    axios.get('/server/php/admin_home.php?action=get_movies')
    .then(function(response) {
        if (response.data.success) {
            const movieList = document.getElementById('movie-list');
            movieList.innerHTML = ''; // 清空現有的電影列表

            response.data.movies.forEach(function(movie) {
                const movieItem = document.createElement('div');
                movieItem.className = 'movie-item';
                movieItem.innerHTML = `
                    <p>電影編號: ${movie.movie_id}</p>
                    <p>電影類型: ${movie.movie_type}</p>
                    <p>電影名稱: ${movie.movie_name}</p>
                    <p>電影等級: ${movie.movie_lv}</p>
                `;
                movieList.appendChild(movieItem);
            });
        } else {
            alert('無法載入電影列表: ' + response.data.message);
        }
    })
    .catch(function(error) {
        console.error('無法載入電影列表:', error);
        alert('無法載入電影列表，請檢查控制台錯誤訊息');
    });
}

// 初始化載入電影列表
loadMovies();