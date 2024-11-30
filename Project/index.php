<?php
$page = "home";
require './controllers/config.php';
include('includes/header.php');
?>

<input type="radio" id="image1" class="carousel-radio primary-container-slider-img" name="image" checked>
<input type="radio" id="image2" class="carousel-radio primary-container-slider-img" name="image">
<input type="radio" id="image3" class="carousel-radio primary-container-slider-img" name="image">

<script>

</script>
<div class="w-full max-w-[1600px] relative primary-container-slider  mt-2">
    <div class="featured-wrapper">
        <ul class="featured-list">
            <li>
                <figure>
                    <img src="./assets/images/hollywood1.jpg" class="w-full h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-[85vh] object-cover" alt="Hollywood Movies">
                    <figcaption class="absolute bottom-10 left-4 md:bottom-16 md:left-8 bg-black bg-opacity-80 p-4 md:p-6 rounded text-sm md:text-lg max-w-[90%] md:max-w-[70%] lg:max-w-[50%]">
                        <h2 class="text-4xl mb-2 text-white">Hollywood</h2>
                        <p class="text-white">Catch the latest Hollywood blockbusters and immerse yourself in thrilling adventures, available anytime at Watcho Theatre!</p>
                    </figcaption>
                </figure>
            </li>

            <li>
                <figure>
                    <img src="./assets/images/bollywood.jpg" class="w-full h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-[85vh] object-cover" alt="Bollywood Movies">
                    <figcaption class="absolute bottom-10 left-4 md:bottom-16 md:left-8 bg-black bg-opacity-80 p-4 md:p-6 rounded text-sm md:text-lg max-w-[90%] md:max-w-[70%] lg:max-w-[50%]">
                        <h2 class="text-4xl mb-2 text-white">Bollywood</h2>
                        <p class="text-white">Dive into the drama, music, and magic of Bollywood. Book your tickets at Watcho Theatre for a memorable movie experience!</p>
                    </figcaption>
                </figure>
            </li>

            <li>
                <figure>
                    <img src="./assets/images/tollywood1.jpg" class="w-full h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-[85vh] object-cover" alt="Tollywood Movies">
                    <figcaption class="absolute bottom-10 left-4 md:bottom-16 md:left-8 bg-black bg-opacity-80 p-4 md:p-6 rounded text-sm md:text-lg max-w-[90%] md:max-w-[70%] lg:max-w-[50%]">
                        <h2 class="text-4xl mb-2 text-white">Tollywood</h2>
                        <p class="text-white">Experience the excitement and grandeur of Tollywood! Reserve your seats at Watcho Theatre and enjoy the finest South Indian cinema.</p>
                    </figcaption>
                </figure>
            </li>
        </ul>


        <!-- Navigation Dots -->
        <ul class="dots absolute bottom-4 w-full flex justify-center items-center z-50   space-x-2 md:space-x-4" id="stuck-slide">
            <li><label for="image1" class="cursor-pointer w-2 h-2 md:w-3 md:h-3 bg-gray-500 rounded-full inline-block"></label></li>
            <li><label for="image2" class="cursor-pointer w-2 h-2 md:w-3 md:h-3 bg-gray-500 rounded-full inline-block"></label></li>
            <li><label for="image3" class="cursor-pointer w-2 h-2 md:w-3 md:h-3 bg-gray-500 rounded-full inline-block"></label></li>
        </ul>
    </div>
</div>



<div class="primary-container min-h-screen flex flex-col gap-6 mx-auto w-full p-6 bg-gray-800">
    <h2 class="font-bold text-2xl text-gray-100 pt-5 pb-2 border-b border-gray-600 tracking-wide uppercase">
        Popular Movies
    </h2>
    <div id="popular-movies-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full p-4">
        <div id="popular-loading" style="display: block;">
            <div class="spinner"></div>
        </div>
    </div>

    <h2 class="font-bold text-2xl text-gray-100 pt-5 pb-2 border-b border-gray-600 tracking-wide uppercase">
        Latest Movies
    </h2>

    <div id="latest-movies-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full p-4">
        <div id="latest-loading" style="display: block;">
            <div class="spinner"></div>
        </div>


    </div>




    <a href="./views/movies.php" class="bg-rose-600 text-white font-medium py-3 px-6 rounded-md w-fit mx-auto">View
        All Movies</a>

    <div class="container mx-auto px-4 py-12 bg-gray-800">
        <h2 class="text-4xl font-bold text-center mb-8 text-white">Our Services</h2>

        <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
            <div class="bg-gray-900 rounded-lg shadow-md p-6 transition hover:shadow-lg cursor-pointer">
                <div class="flex items-start space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-14 text-red-500" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M5 8V20H19V8H5ZM5 6H19V4H5V6ZM20 22H4C3.44772 22 3 21.5523 3 21V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM7 10H11V14H7V10ZM7 16H17V18H7V16ZM13 11H17V13H13V11Z">
                        </path>
                    </svg>
                    <div>
                        <h3 class="text-xl font-semibold text-white">Online Ticket Booking</h3>
                        <p class="mt-2 text-gray-300">Easily book your favorite movies from the comfort of your
                            home.
                            Enjoy a smooth booking experience and skip the queues.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 rounded-lg shadow-md p-6 transition hover:shadow-lg cursor-pointer">
                <div class="flex items-start space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-14 text-red-500" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M8 3C5.79086 3 4 4.79086 4 7V9.12602C2.27477 9.57006 1 11.1362 1 13C1 14.4817 1.8052 15.7734 3 16.4646V19V21H5V20H19V21H21V19V16.4646C22.1948 15.7734 23 14.4817 23 13C23 11.1362 21.7252 9.57006 20 9.12602V7C20 4.79086 18.2091 3 16 3H8ZM18 9.12602C16.2748 9.57006 15 11.1362 15 13H9C9 11.1362 7.72523 9.57006 6 9.12602V7C6 5.89543 6.89543 5 8 5H16C17.1046 5 18 5.89543 18 7V9.12602ZM9 15H15V16H17V13C17 11.8954 17.8954 11 19 11C20.1046 11 21 11.8954 21 13C21 13.8693 20.4449 14.6114 19.6668 14.8865C19.2672 15.0277 19 15.4055 19 15.8293V18H5V15.8293C5 15.4055 4.73284 15.0277 4.33325 14.8865C3.5551 14.6114 3 13.8693 3 13C3 11.8954 3.89543 11 5 11C6.10457 11 7 11.8954 7 13V16H9V15Z">
                        </path>
                    </svg>
                    <div>
                        <h3 class="text-xl font-semibold text-white">Custom Seat Selection</h3>
                        <p class="mt-2 text-gray-300">Choose your preferred seats with our interactive seat map,
                            ensuring the best view for your movie experience.</p>
                    </div>
                </div>
            </div>

            <!-- Service Card 3: Exclusive Deals and Offers -->
            <div class="bg-gray-900 rounded-lg shadow-md p-6 transition hover:shadow-lg cursor-pointer">
                <div class="flex items-start space-x-4">
                    <!-- SVG Icon for Deals -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-14 text-red-500" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M13.8273 1.69L22.3126 10.1753L20.8984 11.5895L20.1913 10.8824L15.9486 15.125L15.2415 18.6606L13.8273 20.0748L9.58466 15.8321L4.63492 20.7819L3.2207 19.3677L8.17045 14.4179L3.92781 10.1753L5.34202 8.76107L8.87756 8.05396L13.1202 3.81132L12.4131 3.10422L13.8273 1.69ZM14.5344 5.22554L9.86358 9.89637L7.0417 10.4607L13.5418 16.9609L14.1062 14.139L18.7771 9.46818L14.5344 5.22554Z">
                        </path>
                    </svg>
                    <div>
                        <h3 class="text-xl font-semibold text-white">Exclusive Deals and Offers</h3>
                        <p class="mt-2 text-gray-300">Discover special discounts, combo offers, and exclusive
                            promotions
                            available only on our platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








<?php require_once './includes/footer.php'; ?>


<script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    const mobileMenu = document.getElementById('mobile-menu');
    let timeout = 4000;
    let index = 1;

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuBtn.classList.toggle('active-btn');
        menuBtn.classList.toggle('text-black');
    });

    let sliderChanger = setInterval(() => {
        if (index <= 3) {
            document.getElementById(`image${index}`).checked = true;
            index++;
        } else {
            index = 1;
        }
    }, timeout);

    $('#stuck-slide').mouseenter(() => {
        clearInterval(sliderChanger);
    });

    $('#stuck-slide').mouseleave(() => {
        sliderChanger = setInterval(() => {
            if (index <= 3) {
                document.getElementById(`image${index}`).checked = true;
                index++;
            } else {
                index = 1;
            }
        }, timeout);
    });






    function showLoading(type) {
        if (type == 'latest_movies') {

            $('#latest-loading').show();

            return
        }

        if (type == 'popular_movies') {


            $('#popular-loading').show();

            return

        }
    }

    function hideLoading(type) {
        if (type == 'latest_movies') {

            $('#latest-loading').hide();

            return
        }

        if (type == 'popular_movies') {


            $('#popular-loading').hide();

            return

        }
    }

    $.ajax({
        url: './controllers/popular_movies.controller.php',
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
            showLoading('popular_movies');
        },
        success: function(data) {
            hideLoading('popular_movies');
            if (data.length > 0) {
                data.forEach(function(movie) {
                    let posterSrc;

                    if (movie.poster_url.slice(0, 5) === "https") {
                        posterSrc = movie.poster_url;
                    } else {
                        posterSrc = `./views/${movie.poster_url}`;
                    }


                    const movieCard = `
                        <article class="relative overflow-hidden rounded-lg shadow-md cursor-pointer w-full h-[460px] transition hover:shadow-xl group" onclick="window.location.href = './views/movie.php?id=${movie.id}';">
                            <img alt="Movie Poster" src="${posterSrc}" class="absolute inset-0 h-full w-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="p-4 sm:p-6 absolute bottom-0">
                                    <h3 class="text-xl font-semibold text-white">${movie.title}</h3>
                                    <p class="mt-2 text-sm text-gray-200">${movie.description}</p>
                                    <div class="details flex flex-wrap items-center gap-x-2 mt-3">
                                        <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Genre: <span>${movie.genres}</span></p>
                                        <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Duration: <span>${movie.duration} mins</span></p>
                                        <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Release: <span>${movie.release_date}</span></p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    `;
                    $('#popular-movies-grid').append(movieCard);
                });
            } else {
                $('#popular-movies-grid').html('<p class="text-gray-200 min-h-[300px] text-2xl flex items-center">No movies available.</p>');
            }
        },
        error: function(xhr, status, error) {
            hideLoading('popular_movies');
            console.error('Error fetching movies:', error);
            $('#popular-movies-grid').html('<p class="text-gray-200 min-h-[300px] text-2xl flex items-center">Failed to load movies.</p>');
        }
    });

    $.ajax({
        url: './controllers/latest_movies.controller.php',
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
            showLoading('latest_movies');
        },
        success: function(data) {
            hideLoading('latest_movies');
            if (data.length > 0) {
                data.forEach(function(movie) {
                    let posterSrc;

                    if (movie.poster_url.slice(0, 5) === "https") {
                        posterSrc = movie.poster_url;
                    } else {
                        posterSrc = `./views/${movie.poster_url}`;
                    }


                    const movieCard = `
                        <article class="relative overflow-hidden rounded-lg shadow-md cursor-pointer w-full h-[460px] transition hover:shadow-xl group" onclick="window.location.href = './views/movie.php?id=${movie.id}';">
                            <img alt="Movie Poster" src="${posterSrc}" class="absolute inset-0 h-full w-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="p-4 sm:p-6 absolute bottom-0">
                                    <h3 class="text-xl font-semibold text-white">${movie.title}</h3>
                                    <p class="mt-2 text-sm text-gray-200">${movie.description}</p>
                                    <div class="details flex flex-wrap items-center gap-x-2 mt-3">
                                        <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Genre: <span>${movie.genres}</span></p>
                                        <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Duration: <span>${movie.duration} mins</span></p>
                                        <p class="text-xs text-white/80 bg-gray-800 px-2 py-1 rounded-md">Release: <span>${movie.release_date}</span></p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    `;
                    $('#latest-movies-grid').append(movieCard);
                });
            } else {
                $('#latest-movies-grid').html('<p class="text-gray-200 min-h-[300px] text-2xl flex items-center">No movies available.</p>');
            }
        },
        error: function(xhr, status, error) {
            hideLoading('latest_movies');
            console.error('Error fetching movies:', error);
            $('#latest-movies-grid').html('<p class="text-gray-200 min-h-[300px] text-2xl flex items-center">Failed to load movies.</p>');
        }
    });
</script>
</body>

</html>