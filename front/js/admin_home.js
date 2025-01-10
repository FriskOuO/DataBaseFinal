let movies = [];

async function addMovie() {
    const movieId = prompt("請輸入電影ID：");
    const movieType = prompt("請輸入電影類型：");
    const movieName = prompt("請輸入電影名稱：");
    const movieLv = prompt("請輸入電影等級：");

    if (movieId && movieType && movieName && movieLv) {
        try {
            const response = await fetch('http://127.0.0.1:3000/DataBaseFinal-main/server/php/movie.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ movie_id: movieId, movie_type: movieType, movie_name: movieName, movie_lv: movieLv })
            });
            if (response.ok) {
                const result = await response.json();
                if (result.message) {
                    alert(`電影「${movieName}」已成功上架！`);
                    displayMovies();
                } else {
                    alert(result.error);
                }
            } else {
                alert('上架電影失敗');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('上架電影失敗');
        }
    } else {
        alert('請填寫所有欄位');
    }
}

async function removeMovie() {
    const movieId = prompt("請輸入要下架的電影ID：");
    if (movieId) {
        try {
            const response = await fetch(`http://127.0.0.1:3000/DataBaseFinal-main/server/php/movie.php/${movieId}`, {
                method: 'DELETE'
            });
            if (response.ok) {
                const result = await response.json();
                if (result.message) {
                    alert(`電影ID「${movieId}」已成功下架！`);
                    displayMovies();
                } else {
                    alert(result.error);
                }
            } else {
                alert('下架電影失敗');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('下架電影失敗');
        }
    }
}

async function searchMovie() {
    const query = document.getElementById('search-input').value;
    if (query) {
        try {
            const response = await fetch(`http://127.0.0.1:3000/DataBaseFinal-main/server/php/movie.php?search=${query}`);
            if (response.ok) {
                const results = await response.json();
                alert(`搜尋結果：${results.map(movie => movie.movie_name).join(', ')}`);
            } else {
                alert('搜尋電影失敗');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('搜尋電影失敗');
        }
    }
}

async function displayMovies() {
    try {
        const response = await fetch('http://127.0.0.1:3000/DataBaseFinal-main/server/php/movie.php');
        if (response.ok) {
            movies = await response.json();
            const movieList = document.getElementById('movie-list');
            movieList.innerHTML = '';
            movies.forEach(movie => {
                const movieItem = document.createElement('div');
                movieItem.textContent = `${movie.movie_name} (${movie.movie_type}, 等級: ${movie.movie_lv})`;
                movieList.appendChild(movieItem);
            });
        } else {
            alert('獲取電影列表失敗');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('獲取電影列表失敗');
    }
}

function logout() {
    alert("您已成功登出！");
    // 在這裡添加登出的邏輯
}

// 初始化顯示電影列表
document.addEventListener('DOMContentLoaded', displayMovies);