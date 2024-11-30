<?php
$page = "favorites";
include('../includes/header.php');
?>

<div class="primary-container min-h-screen flex flex-col gap-6 mx-auto w-full p-6 bg-gray-800">
    <h1 class="font-bold text-4xl text-gray-100 pt-5 pb-4 border-b border-gray-600 tracking-wide uppercase">
        Favorite movies
    </h1>
    <div id="favorite-movies-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full p-4">
    </div>

</div>


<!-- <div
                class="movie-templete relative rounded-lg flex flex-col shadow-md cursor-pointer w-full transition hover:shadow-xl group">
                <img alt="Movie Poster" src="../assets/images/oppenheimer.webp" class="h-[350px] w-full object-cover" />
                <div
                    class="flex items-center z-30 bg-black opacity-0 group-hover:opacity-35 justify-center w-full h-full absolute top-0 left-0 transition duration-400">
                </div>
                <div
                    class="flex items-center z-40 bg-transparent opacity-0 group-hover:opacity-100 justify-center w-full h-full absolute top-0 left-0 transition duration-400">
                    <div
                        class="remove-fav flex flex-col justify-center items-center p-2 transition duration-300 hover:bg-zinc-900 rounded-full size-[100px]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="text-red-600 size-14"
                            fill="currentcolor">
                            <path
                                d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853Z">
                            </path>
                        </svg>
                        <span class="text-sm text-zinc-100 text-center tracking-lighter leading-4">Remove</span>
                    </div>
                    <div
                        class="view-movie flex flex-col justify-center items-center p-2 transition duration-300 hover:bg-zinc-900 rounded-full size-[100px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-white size-14" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M2 4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4ZM4 5V19H20V5H4ZM6 7H8V9H6V7ZM8 11H6V13H8V11ZM6 15H8V17H6V15ZM18 7H10V9H18V7ZM10 15H18V17H10V15ZM18 11H10V13H18V11Z">
                            </path>
                        </svg>
                        <span class="text-sm text-zinc-100 text-center tracking-lighter leading-4">View</span>
                    </div>
                </div>
                <div class="p-4 sm:p-6 bg-gray-700 relative w-full flex-grow flex flex-col justify-center">
                    <h3 class="text-xl font-semibold text-white">Oppenheimer</h3>
                    <p class="mt-1 text-sm text-gray-200">An amazing journey into history and science. </p>
                    <div class="details flex flex-wrap items-center gap-x-2 gap-y-1 mt-4">
                        <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Genre: <span>Drama</span>
                        </p>
                        <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Duration: <span>3h
                                1m</span></p>
                        <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Release: <span>10th Oct
                                2022</span></p>
                    </div>
                </div>
            </div> -->

<!-- FOOTER  -->

<?php require_once '../includes/footer.php'; ?>


<script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuBtn.classList.toggle('active-btn');
        menuBtn.classList.toggle('text-black');
    });

    $.ajax({
        url: '../controllers/fetch_favorites.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data.length > 0) {
                const favoriteMoviesGrid = $('#favorite-movies-grid');
                favoriteMoviesGrid.empty(); // Clear any existing content

                response.data.forEach(movie => {
                    let posterSrc = '';
                    if (movie.poster_url.slice(0, 5) === "https") {
                        posterSrc = movie.poster_url;
                    } else {
                        posterSrc = `.${movie.poster_url}`;
                    }
                    const genres = movie.genres.join(', ') || 'No genres available';

                    const movieItem = `
                    <div id='movie-${movie.movie_id}' class="relative rounded-lg flex flex-col shadow-md cursor-pointer w-full transition hover:shadow-xl group">
                        <img alt="Movie Poster" src="${posterSrc}" class="h-[350px] w-full object-cover" />
                        <div class="flex items-center z-30 bg-black opacity-0 group-hover:opacity-35 justify-center w-full h-full absolute top-0 left-0 transition duration-400"></div>
                        <div class="flex items-center z-40 bg-transparent opacity-0 group-hover:opacity-100 justify-center w-full h-full absolute top-0 left-0 transition duration-400">
                            <div class="remove-fav flex flex-col justify-center items-center p-2 transition duration-300 hover:bg-zinc-900 rounded-full size-[100px]" onclick="removeFromFavorites(${movie.movie_id})">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="text-red-600 size-14" fill="currentColor"><path d="M2.80777 1.3934L21.1925 19.7782L19.7783 21.1924L16.0316 17.4454L12 21.485L3.52154 12.993C1.48186 10.7094 1.49309 7.24014 3.55524 4.96959L1.39355 2.80762L2.80777 1.3934ZM4.98009 11.6232L12 18.6543L14.6176 16.0314L4.97206 6.38623C3.67816 7.88265 3.67138 10.121 4.98009 11.6232ZM20.2428 4.75736C22.5054 7.02472 22.5831 10.637 20.4788 12.993L18.8442 14.629L17.4302 13.215L19.0202 11.6232C20.3937 10.0467 20.3191 7.66525 18.8271 6.1701C17.3281 4.66794 14.9078 4.60702 13.3371 6.01688L12.0021 7.21524L10.6662 6.01781C10.3163 5.70415 9.92487 5.46325 9.51117 5.29473L7.2604 3.04551C8.92926 2.83935 10.6682 3.33369 12.0011 4.52853C14.3502 2.42 17.9802 2.49 20.2428 4.75736Z"></path></svg>
                                <span class="text-sm text-zinc-100 text-center tracking-lighter leading-4">Remove</span>
                            </div>
                            <div class="view-movie flex flex-col justify-center items-center p-2 transition duration-300 hover:bg-zinc-900 rounded-full size-[100px]" onclick="window.location.href = './movie.php?id=${movie.movie_id}';">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-white size-14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2 4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4ZM4 5V19H20V5H4ZM6 7H8V9H6V7ZM8 11H6V13H8V11ZM6 15H8V17H6V15ZM18 7H10V9H18V7ZM10 15H18V17H10V15ZM18 11H10V13H18V11Z"></path>
                                </svg>
                                <span class="text-sm text-zinc-100 text-center tracking-lighter leading-4">View</span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 bg-gray-700 relative w-full flex-grow flex flex-col justify-center">
                            <h3 class="text-xl font-semibold text-white">${movie.title}</h3>
                            <p class="mt-1 text-sm text-gray-200">${movie.description}</p>
                            <div class="details flex flex-wrap items-center gap-x-2 gap-y-1 mt-4">
                                <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Genre: <span>${genres}</span></p>
                                <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Duration: <span>${movie.duration} mins</span></p>
                                <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Release: <span>${movie.release_date}</span></p>
                            </div>
                        </div>
                    </div>
                    `;
                    favoriteMoviesGrid.append(movieItem);
                });
            } else {
                $('#favorite-movies-grid').html(`<div class="grid h-[70vh] col-span-4 place-content-center px-4">
  <h1 class="uppercase tracking-widest text-gray-500 text-gray-400">No favorite movies found.</h1>
</div>`);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching favorite movies:", error);
        }
    });


    function removeFromFavorites(movie_id) {
        $.ajax({
            url: `../controllers/remove_favorite.php?movie_id=${movie_id}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $(`#movie-${movie_id}`).remove();

                    const favoriteMoviesGrid = $('#favorite-movies-grid');
                    if (favoriteMoviesGrid.children().length === 0) {
                        favoriteMoviesGrid.html(`<div class="grid h-[70vh] col-span-4 place-content-center px-4">
  <h1 class="uppercase tracking-widest text-gray-500 text-gray-400">No favorite movies found.</h1>
</div>`);
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error removing movie from favorites:', error);
                alert('An error occurred while removing the movie from favorites.');
            }
        });
    }
</script>
</body>

</html>