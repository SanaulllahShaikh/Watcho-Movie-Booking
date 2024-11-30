<?php
$page = "movies";
include('../includes/header.php');
include_once "../controllers/config.php";

$fetchGenres = "SELECT genre_id, genre_name FROM genres";
$result = $conn->query($fetchGenres);

if ($result->num_rows > 0) {
    $genres = [];
    while ($row = $result->fetch_assoc()) {
        $genres[] = $row;
    }
} else {
    $genres = [];
}


$fetchReleaseDate = "SELECT DISTINCT YEAR(release_date) AS release_year FROM movies WHERE is_published = 1 ORDER BY release_year DESC";
$result = $conn->query($fetchReleaseDate);

if ($result->num_rows > 0) {
    $release_years = [];
    while ($row = $result->fetch_assoc()) {
        $release_years[] = $row['release_year'];
    }
} else {
    $release_years = [];
}


$conn->close();
?>



<div class="primary-container min-h-screen flex flex-col gap-6 mx-auto w-full p-6 bg-gray-800">


    <!-- Filter Options -->
    <form action="movies.php" method="POST">

        <div class="flex flex-wrap w-full gap-4 items-end justify-between my-6">
            <div class="left-side flex flex-wrap gap-x-4 gap-y-2 items-end">
                <div class="flex flex-col items-start">
                    <label for="genre" class="text-gray-300 mb-1">Genre</label>
                    <select id="genre" class="bg-gray-700 text-gray-300 p-2 rounded-md">
                        <option value="">All Genres</option>
                        <?php if (!empty($genres)) {
                            foreach ($genres as $genre) { ?>
                                <option value="<?php echo $genre['genre_id']; ?>">
                                    <?php echo htmlspecialchars($genre['genre_name']); ?>
                                </option>
                        <?php }
                        } ?>
                    </select>
                </div>

                <div class="flex flex-col items-start">
                    <label for="release-date" class="text-gray-300 mb-1">Release Date</label>
                    <select id="release-date" class="bg-gray-700 text-gray-300 p-2 rounded-md">
                        <option value="">All Dates</option>
                        <?php if (!empty($release_years)) {
                            foreach ($release_years as $year) { ?>
                                <option value="<?php echo $year; ?>">
                                    <?php echo htmlspecialchars($year); ?>
                                </option>
                        <?php }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="right-side w-full md:max-w-[350px]">
                <input id="search-input" type="text" placeholder="Search movie by title or description."
                    class="min-w-[350px] w-full h-12 max-w-md bg-gray-700 text-gray-300 p-2 pl-4 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600" />
            </div>

        </div>
    </form>


    <div id="movies-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full p-4">

    </div>
    <div id="pagination" class="flex justify-center mt-4 space-x-2"></div>

</div>




<?php require_once '../includes/footer.php'; ?>


<script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    const mobileMenu = document.getElementById('mobile-menu');
    let currentPage = 1;
    const limit = 8;

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuBtn.classList.toggle('active-btn');
        menuBtn.classList.toggle('text-black');
    });


    function fetchMovies(page = 1, searchQuery = '', genreId = '', releaseYear = '') {
        $.ajax({
            url: '../controllers/fetch_movies.php',
            type: 'GET',
            data: {
                page,
                limit,
                search: searchQuery,
                genre: genreId,
                release_date: releaseYear
            },
            dataType: 'json',
            success: function(response) {
                const {
                    movies,
                    pagination
                } = response;

                $('#movies-grid').html('');

                if (movies.length > 0) {
                    movies.forEach(function(movie) {
                        const moviePoster = movie.poster_url.startsWith('http') ? movie.poster_url : '.' + movie.poster_url;

                        const movieTemplate = `
                    <div class="movie-templete relative rounded-lg flex flex-col shadow-md cursor-pointer w-full transition hover:shadow-xl group" onclick="window.location.href = './movie.php?id=${movie.movie_id}';">
                        <img alt="${movie.title}" src="${moviePoster}" class="h-[350px] w-full object-cover" />
                        <div class="flex items-center z-40 bg-black opacity-0 group-hover:opacity-25 justify-center w-full h-full absolute top-0 left-0 transition duration-400">
                        </div>
                        <div class="p-4 sm:p-6 bg-gray-700 relative w-full flex-grow flex flex-col justify-between">
                        <div>
                        
                            <h3 class="text-xl font-semibold text-white">${movie.title}</h3>
                            <p class="mt-1 text-sm text-gray-200">${movie.description}</p>
                        </div>
                            <div class="details flex flex-wrap items-center gap-x-2 gap-y-1 mt-4">
                                ` + (movie.genres ? `<p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Genre: <span>${movie.genres}</span></p>` : '') + `
                                <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Duration: <span>${movie.duration} min</span></p>
                                <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Release: <span>${movie.release_date}</span></p>
                            </div>
                        </div>
                    </div>
                    `;
                        $('#movies-grid').append(movieTemplate);
                    });
                } else {
                    $('#movies-grid').append(`<div class="grid h-[50vh] col-span-4 place-content-center px-4">
  <h1 class="uppercase tracking-widest text-gray-500 text-gray-400">No movies found.</h1>
</div>`);
                }

                updatePagination(pagination);
            },
            error: function() {
                $('#movies-grid').html('<p class="no-fetch-movie text-2xl text-center font-bold mt-8 text-red-500 w-full col-span-4">There was an error fetching movie data.</p>');
            }
        });
    }

    $('#release-date').on('change', function() {
        const selectedReleaseYear = $(this).val();
        currentPage = 1;
        fetchMovies(currentPage, $('#search-input').val(), $('#genre').val(), selectedReleaseYear);
    });


    function updatePagination(pagination) {
        const {
            current_page,
            total_pages
        } = pagination;
        $('#pagination').html('');

        if (total_pages > 1) {
            if (current_page > 1) {
                $('#pagination').append(`
                <button 
                    class="pagination-button bg-gray-300 px-3 py-1 rounded-md"
                    data-page="${current_page - 1}">
                    Previous
                </button>
            `);
            }

            for (let i = 1; i <= total_pages; i++) {
                const activeClass = i === current_page ? 'bg-blue-500 text-white' : 'bg-gray-300';
                $('#pagination').append(`
                <button 
                    class="pagination-button ${activeClass} px-3 py-1 rounded-md"
                    data-page="${i}">
                    ${i}
                </button>
            `);
            }

            // Next Button
            if (current_page < total_pages) {
                $('#pagination').append(`
                <button 
                    class="pagination-button bg-gray-300 px-3 py-1 rounded-md"
                    data-page="${current_page + 1}">
                    Next
                </button>
            `);
            }
        }
    }

    $(document).on('click', '.pagination-button', function() {
        const page = $(this).data('page');
        if (page !== currentPage) {
            currentPage = page;
            fetchMovies(page, $('#search-input').val(), $('#genre').val());
        }
    });

    $('#search-input').on('input', function() {
        const searchQuery = $(this).val();
        currentPage = 1;
        fetchMovies(currentPage, searchQuery, $('#genre').val());
    });

    $('#genre').on('change', function() {
        const selectedGenre = $(this).val();
        currentPage = 1;
        fetchMovies(currentPage, $('#search-input').val(), selectedGenre);
    });

    fetchMovies();
</script>
</body>

</html>