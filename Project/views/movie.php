<?php
$page = "movie";
require '../controllers/config.php';
include_once('../includes/header.php');

$movie_id = $_GET['id'] ?? 1;
$query = "SELECT * FROM movies WHERE movie_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();

if (!$movie) {
    echo "Movie not found!";
    exit;
}

$query = "
    SELECT g.genre_name
    FROM genres g
    JOIN movie_genres mg ON g.genre_id = mg.genre_id
    WHERE mg.movie_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

$genres = [];
while ($row = $result->fetch_assoc()) {
    $genres[] = $row['genre_name'];
}

$genres_string = implode(', ', $genres);

$query = "
    SELECT AVG(rating) AS avg_rating
    FROM reviews
    WHERE movie_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$rating_data = $result->fetch_assoc();
$average_rating = round($rating_data['avg_rating'], 1);
$average_rating = $average_rating ?: 0;

$query = "
    SELECT COUNT(*) AS total_reviews
    FROM reviews
    WHERE movie_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$review_data = $result->fetch_assoc();
$total_reviews = $review_data['total_reviews'] ?? 0;

$movie_title = $movie['title'];
$movie_poster = $movie['poster_url'];

if (substr($movie_poster, 0, 4) !== 'http') {
    $movie_poster = '.' . $movie_poster;
}

$movie_banner = $movie['banner_url'];
$movie_trailer = $movie['trailer_url'] ?? '';

if (substr($movie_banner, 0, 4) !== 'http') {
    $movie_banner = '.' . $movie_banner;
}


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sqlCheck = "SELECT * FROM favorites WHERE user_id = ? AND movie_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("ii", $user_id, $movie_id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
}


$movie_release_date = $movie['release_date'];
$movie_duration = $movie['duration'];
$movie_description = $movie['description'];
?>

<div class="primary-container min-h-screen flex flex-col gap-2 mx-auto w-full py-6 bg-gray-800">
    <div class="flex justify-center mb-4 w-full bg-black">
        <?php if ($movie_trailer): ?>
            <video
                id="my-video"
                class="video-js"
                controls
                preload="auto"
                height="364"
                class="w-screen"
                poster="<?php echo $movie_banner; ?>"
                data-setup="{}">
                <source src=".<?php echo $movie_trailer; ?>" type="video/mp4" />
                <source src="MY_VIDEO.webm" type="video/webm" />
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a
                    web browser that
                    <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                </p>
            </video>
        <?php else: ?>
            <div width="100%" height="200px" class="flex justify-center items-center rounded-lg shadow-md min-h-[200px]">
                <h2 class="text-center text-lg text-gray-200">No Trailer Found</h2>
            </div>
        <?php endif; ?>
    </div>

    <div class="primary-container min-h-screen flex flex-col md:flex-row gap-6 mx-auto w-full p-4 bg-gray-800">
        <div
            class="movie-template w-full hidden lg:block lg:w-1/2 relative rounded-lg shadow-md cursor-pointer transition hover:shadow-xl group">
            <img alt="Movie Poster" src="<?php echo $movie_poster; ?>"
                class="h-full max-h-[700px] w-full object-cover rounded-lg" />
        </div>

        <div class="details w-full lg:w-1/2 space-y-6 text-gray-100">
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <div class="text-2xl flex font-semibold gap-2 text-yellow-500 items-center">
                        <div class="rating-star flex gap-1">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo ($i <= $average_rating) ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-7 text-yellow-500" fill="currentColor"><path d="M11.9998 17L6.12197 20.5902L7.72007 13.8906L2.48926 9.40983L9.35479 8.85942L11.9998 2.5L14.6449 8.85942L21.5104 9.40983L16.2796 13.8906L17.8777 20.5902L11.9998 17Z"></path></svg>' :
                                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-7 text-gray-400" fill="currentColor"><path d="M11.9998 17L6.12197 20.5902L7.72007 13.8906L2.48926 9.40983L9.35479 8.85942L11.9998 2.5L14.6449 8.85942L21.5104 9.40983L16.2796 13.8906L17.8777 20.5902L11.9998 17Z"></path></svg>';
                            }
                            ?>
                        </div>
                    </div>
                    <span class="text-gray-200"><?php echo $average_rating; ?> / 10</span>
                    <span class="text-gray-300 text-xs mb-2">( <?php echo $total_reviews; ?> )</span>
                </div>

                <h1 class="text-4xl font-bold"><?php echo $movie_title; ?></h1>

                <div class="text-lg text-gray-400 flex flex-col sm:flex-row items-start sm:items-center gap-2">
                    <span>Released: <strong class="truncate"><?php echo $movie_release_date; ?></strong></span>
                    <span class="hidden sm:inline sm:mx-2">|</span>
                    <span>Genre: <strong class="truncate"><?php echo $genres_string; ?></strong></span>
                    <span class="hidden sm:inline sm:mx-2">|</span>
                    <span>Duration: <strong class="truncate"><?php echo $movie_duration; ?>m</strong></span>
                </div>

                <div class="pt-4 flex flex-col gap-6 border-t border-gray-600">
                    <div class="flex flex-col md:flex-row gap-4 w-full">
                        <div class="w-full" id="favoriteBtnContainer">
                            <?php
                            if (isset($_SESSION['user_id']) && $resultCheck->num_rows > 0) {
                            ?>
                                <button onclick="addToFavorite(<?= $movie_id; ?>)"
                                    class="bg-gray-700 hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center shadow-md transition transform hover:scale-105 w-full">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-7 text-red-500 mr-1" fill="currentColor">
                                        <path d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853ZM18.827 6.1701C17.3279 4.66794 14.9076 4.60701 13.337 6.01687L12.0019 7.21524L10.6661 6.01781C9.09098 4.60597 6.67506 4.66808 5.17157 6.17157C3.68183 7.66131 3.60704 10.0473 4.97993 11.6232L11.9999 18.6543L19.0201 11.6232C20.3935 10.0467 20.319 7.66525 18.827 6.1701Z"></path>
                                    </svg>
                                    Remove from Favorites
                                </button>
                            <?php
                            } else {
                            ?>
                                <button onclick="addToFavorite(<?= $movie_id; ?>)"
                                    class="bg-gray-700 hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center shadow-md transition transform hover:scale-105 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-7 text-red-500" fill="currentColor">
                                        <path d="M11.9998 17L6.12197 20.5902L7.72007 13.8906L2.48926 9.40983L9.35479 8.85942L11.9998 2.5L14.6449 8.85942L21.5104 9.40983L16.2796 13.8906L17.8777 20.5902L11.9998 17Z"></path>
                                    </svg>
                                    Add to Favorites
                                </button>
                            <?php } ?>
                        </div>

                        <button onclick="bookTicket(<?php
                                                    if (!isset($_SESSION['user_id'])) {
                                                        echo 'true ,' . $movie_id;
                                                    } else {
                                                        echo 'false ,' . $movie_id;
                                                    }
                                                    ?>)" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 shadow-md transition transform hover:scale-105 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-7 text-yellow-500" fill="currentColor">
                                <path d="M21.0049 2.99966C21.5572 2.99966 22.0049 3.44738 22.0049 3.99966V9.49966C20.6242 9.49966 19.5049 10.619 19.5049 11.9997C19.5049 13.3804 20.6242 14.4997 22.0049 14.4997V19.9997C22.0049 20.5519 21.5572 20.9997 21.0049 20.9997H3.00488C2.4526 20.9997 2.00488 20.5519 2.00488 19.9997V14.4997C3.38559 14.4997 4.50488 13.3804 4.50488 11.9997C4.50488 10.619 3.38559 9.49966 2.00488 9.49966V3.99966C2.00488 3.44738 2.4526 2.99966 3.00488 2.99966H21.0049Z"></path>
                            </svg>
                            Book Now
                        </button>
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold mb-3">About the Movie</h2>
                        <p class="text-gray-300 leading-relaxed"><?= htmlspecialchars($movie_description) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<?php require_once '../includes/footer.php'; ?>

<script src="../library/videojs/video.min.js"></script>
<script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuBtn.classList.toggle('active-btn');
        menuBtn.classList.toggle('text-black');
    });

    function openModal(title, description, type = "default", id = 0) {
        const modal = document.createElement('div');
        let titleTag = "";
        let descriptionTag = "";
        let actionButtons = "";

        switch (type) {
            case "danger":
                titleTag = `<h2 class="text-2xl font-semibold text-red-400 w-full">${title}</h2>`;
                descriptionTag = `<p class="mt-2 text-gray-600 w-full py-2">${description}</p>`;
                actionButtons = `
                <div class="flex w-full justify-around gap-4 mt-6">
                    <button onclick="applyAction(${id})" class="px-8 w-full py-3 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
                    <button onclick="closeModal()" class="px-8 w-full py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Dismiss</button>
                </div>
            `;
                break;
            case "info":

                titleTag = `<h2 class="text-xl font-bold w-full">${title}</h2>`;
                descriptionTag = `<p class="mt-4 text-gray-600 w-full py-2">${description}</p>`;
                actionButtons = `
                <div class="flex justify-center w-full mt-6">
                    <button onclick="closeModal()" class="px-6 py-2 w-full bg-blue-200 text-gray-950 rounded-lg hover:bg-gray-300">CLOSE</button>
                </div>
            `;
                break;
            default:
                titleTag = `<h2 class="text-lg font-bold w-full">${title}</h2>`;
                descriptionTag = `<p class="mt-4 text-gray-600 w-full py-2">${description}</p>`;
                actionButtons = `
                <div class="flex justify-center w-full mt-6">
                    <button onclick="closeModal()" class="px-6 py-2 w-full bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">OK</button>
                </div>
            `;
                break;
        }

        modal.id = 'info-modal';
        modal.className = 'fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 overflow-hidden z-50';
        modal.innerHTML = `
        <div class="bg-white w-11/12 md:w-1/2 p-8 flex flex-col justify-center items-center rounded-lg shadow-lg">
            <div class="flex justify-end items-center w-full">
            </div>
            ${titleTag}
            ${descriptionTag}
            
            ${actionButtons}
        </div>
    `;

        document.body.appendChild(modal);

        document.body.style.overflow = 'hidden';

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    }

    function closeModal() {
        const modal = document.getElementById('info-modal');
        if (modal) {
            modal.remove();
        }

        document.body.style.overflow = '';
    }

    function applyAction(movie_id) {
        console.log("Action applied!");


        closeModal();
    }

    function addToFavorite(movieId) {
        $.ajax({
            url: '../controllers/add_to_favorites.php',
            type: 'POST',
            data: {
                movie_id: movieId
            },
            success: function(response) {
                if (response.success_type == "addedMovieToFavorite") {
                    openModal('Successfully movie added', response.message, "info");
                    document.getElementById('favoriteBtnContainer').innerHTML = `
                                                    <button onclick="addToFavorite(<?= $movie_id; ?>)"
                                    class="bg-gray-700 hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center shadow-md transition transform hover:scale-105 w-full">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-7 text-red-500 mr-1" fill="currentColor">
                                        <path d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853ZM18.827 6.1701C17.3279 4.66794 14.9076 4.60701 13.337 6.01687L12.0019 7.21524L10.6661 6.01781C9.09098 4.60597 6.67506 4.66808 5.17157 6.17157C3.68183 7.66131 3.60704 10.0473 4.97993 11.6232L11.9999 18.6543L19.0201 11.6232C20.3935 10.0467 20.319 7.66525 18.827 6.1701Z"></path>
                                    </svg>
                                    Remove from Favorites
                                </button>
                    `;
                }
                if (response.success_type == "removedMovieFromFavorite") {
                    openModal('Successfully movie removed', response.message, "info");
                    document.getElementById('favoriteBtnContainer').innerHTML = `
                                               <button onclick="addToFavorite(<?= $movie_id; ?>)"
                                    class="bg-gray-700 hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center shadow-md transition transform hover:scale-105 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-7 text-red-500" fill="currentColor">
                                        <path d="M11.9998 17L6.12197 20.5902L7.72007 13.8906L2.48926 9.40983L9.35479 8.85942L11.9998 2.5L14.6449 8.85942L21.5104 9.40983L16.2796 13.8906L17.8777 20.5902L11.9998 17Z"></path>
                                    </svg>
                                    Add to Favorites
                                </button>
                    `

                }
                if (response.success_type == "loginToFavorite") {
                    openModal('Please Login to continue.', response.message, "error");

                    return
                }

                if (response.error) {
                    openModal('Error occured.', response.message, "error");

                }
            },
            error: function(xhr, status, error) {
                console.error("Error adding to favorites:", error);
                alert("An unexpected error occurred. Please try again later.");
            }
        });
    }


    function bookTicket(success_type, movieId) {
        if (success_type) {
            openModal('Please Login to continue.', 'Please login to continue booking', "error");
            return
        } else {
            window.location.href = `./book_seat.php?movie_id=${movieId}`;
        }
    }
</script>
</body>

</html>