<?php
$active_tab = 'index';
include './includes/header.php';
require_once '../controllers/config.php';

// Initialize counts
$TotalUsers = 0;
$TotalMovies = 0;
$TotalCinemas = 0;
$TotalShows = 0;
$OneDayNewUsers = 0;
$ThreeDayNewUsers = 0;
$SevenDayNewUsers = 0;

// Fetch Total Users
$stmt = $conn->prepare("SELECT COUNT(*) FROM users");
$stmt->execute();
$stmt->bind_result($TotalUsers);
$stmt->fetch();
$stmt->close();
if ($TotalUsers <= 0) {
    $TotalUsers = 0;
}

// Fetch Total Movies
$stmt = $conn->prepare("SELECT COUNT(*) FROM movies");
$stmt->execute();
$stmt->bind_result($TotalMovies);
$stmt->fetch();
$stmt->close();
if ($TotalMovies <= 0) {
    $TotalMovies = 0;
}

// Fetch Total Cinemas
$stmt = $conn->prepare("SELECT COUNT(*) FROM cinemas");
$stmt->execute();
$stmt->bind_result($TotalCinemas);
$stmt->fetch();
$stmt->close();
if ($TotalCinemas <= 0) {
    $TotalCinemas = 0;
}

// Fetch Total Shows
$stmt = $conn->prepare("SELECT COUNT(*) FROM shows");
$stmt->execute();
$stmt->bind_result($TotalShows);
$stmt->fetch();
$stmt->close();
if ($TotalShows <= 0) {
    $TotalShows = 0;
}

// Fetch New Users in the Last 1 Day
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE created_at >= CURDATE() - INTERVAL 1 DAY");
$stmt->execute();
$stmt->bind_result($OneDayNewUsers);
$stmt->fetch();
$stmt->close();
if ($OneDayNewUsers <= 0) {
    $OneDayNewUsers = 0;
}

// Fetch New Users in the Last 3 Days
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE created_at >= CURDATE() - INTERVAL 3 DAY");
$stmt->execute();
$stmt->bind_result($ThreeDayNewUsers);
$stmt->fetch();
$stmt->close();
if ($ThreeDayNewUsers <= 0) {
    $ThreeDayNewUsers = 0;
}

// Fetch New Users in the Last 7 Days
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE created_at >= CURDATE() - INTERVAL 7 DAY");
$stmt->execute();
$stmt->bind_result($SevenDayNewUsers);
$stmt->fetch();
$stmt->close();
if ($SevenDayNewUsers <= 0) {
    $SevenDayNewUsers = 0;
}




?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">ADMIN PANEL</h1>
            <a href="./upload_movie.php" class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Upload
            </a>
        </div>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-[#222831] shadow-[#151515] shadow-md rounded-lg p-4">
                <h2 class="text-md font-base text-[#EEEEEE]">TOTAL USERS</h2>
                <div class="flex items-center justify-between">

                    <p class="text-3xl font-bold text-[#EEEEEE]" id="total-users"><?= $TotalUsers ?></p>
                    <span><svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-[#DDE6ED]"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M5.23379 7.72989C6.65303 5.48625 9.15342 4 12.0002 4C14.847 4 17.3474 5.48625 18.7667 7.72989L20.4569 6.66071C18.6865 3.86199 15.5612 2 12.0002 2C8.43928 2 5.31393 3.86199 3.54356 6.66071L5.23379 7.72989ZM12.0002 20C9.15342 20 6.65303 18.5138 5.23379 16.2701L3.54356 17.3393C5.31393 20.138 8.43928 22 12.0002 22C15.5612 22 18.6865 20.138 20.4569 17.3393L18.7667 16.2701C17.3474 18.5138 14.847 20 12.0002 20ZM12 8C12.5523 8 13 8.44772 13 9C13 9.55228 12.5523 10 12 10C11.4477 10 11 9.55228 11 9C11 8.44772 11.4477 8 12 8ZM12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12ZM12 15C10.8954 15 10 15.8954 10 17H8C8 14.7909 9.79086 13 12 13C14.2091 13 16 14.7909 16 17H14C14 15.8954 13.1046 15 12 15ZM3 11C2.44772 11 2 11.4477 2 12C2 12.5523 2.44772 13 3 13C3.55228 13 4 12.5523 4 12C4 11.4477 3.55228 11 3 11ZM0 12C0 10.3431 1.34315 9 3 9C4.65685 9 6 10.3431 6 12C6 13.6569 4.65685 15 3 15C1.34315 15 0 13.6569 0 12ZM20 12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12C22 12.5523 21.5523 13 21 13C20.4477 13 20 12.5523 20 12ZM21 9C19.3431 9 18 10.3431 18 12C18 13.6569 19.3431 15 21 15C22.6569 15 24 13.6569 24 12C24 10.3431 22.6569 9 21 9Z">
                            </path>
                        </svg></span>
                </div>
            </div>
            <div class="bg-[#222831] shadow-[#151515] shadow-md rounded-lg p-4">
                <h2 class="text-md font-base text-[#EEEEEE]">TOTAL MOVIES</h2>
                <div class="flex items-center justify-between">

                    <p class="text-3xl font-bold text-[#EEEEEE]" id="total-movies"><?= $TotalMovies ?></p>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            class="size-8 text-[#DDE6ED]" fill="currentColor">
                            <path
                                d="M20.4668 8.69379L20.7134 8.12811C21.1529 7.11947 21.9445 6.31641 22.9323 5.87708L23.6919 5.53922C24.1027 5.35653 24.1027 4.75881 23.6919 4.57612L22.9748 4.25714C21.9616 3.80651 21.1558 2.97373 20.7238 1.93083L20.4706 1.31953C20.2942 0.893489 19.7058 0.893489 19.5293 1.31953L19.2761 1.93083C18.8442 2.97373 18.0384 3.80651 17.0252 4.25714L16.308 4.57612C15.8973 4.75881 15.8973 5.35653 16.308 5.53922L17.0677 5.87708C18.0555 6.31641 18.8471 7.11947 19.2866 8.12811L19.5331 8.69379C19.7136 9.10792 20.2864 9.10792 20.4668 8.69379ZM14.3075 3H14.3414C14.1203 3.62556 14 4.29873 14 5C14 5.70127 14.1203 6.37444 14.3414 7H11.9981L14.3075 3ZM20 11V19H4V6.46076L5.99807 3H2.9918C2.45531 3 2 3.44476 2 3.9934V20.0066C2 20.5551 2.44405 21 2.9918 21H21.0082C21.5447 21 22 20.5552 22 20.0066V11H20ZM8.30747 3L5.99807 7H9.68867L11.9981 3H8.30747Z">
                            </path>
                        </svg>


                    </span>
                </div>
            </div>

            <div class="bg-[#222831] shadow-[#151515] shadow-md rounded-lg p-4">
                <h2 class="text-md font-base text-[#EEEEEE]">TOTAL CINEMA</h2>
                <div class="flex items-center justify-between">

                    <p class="text-3xl font-bold text-[#EEEEEE]" id="total-theatres"><?= $TotalCinemas ?></p>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-[#DDE6ED]"
                            fill="currentColor" shape-rendering="geometricPrecision"
                            text-rendering="geometricPrecision" image-rendering="optimizeQuality"
                            fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 411.93">
                            <path
                                d="M438.84 265.71h-50.75c-11.29 0-20.52 9.24-20.52 20.52v15.02h18.62c9.37 0 17.88 3.82 24.04 9.98 1.17 1.17 2.26 2.43 3.25 3.77.99-1.32 2.06-2.56 3.22-3.72l.08-.08c6.18-6.14 14.66-9.95 23.95-9.95h18.62v-15.02c0-11.29-9.23-20.52-20.51-20.52zm-160.38-135.5c3.56-2.31 3.56-4.88 0-6.92l-36.9-21.21c-2.92-1.83-5.96-.75-5.87 3.05l.12 42.87c.24 4.12 2.6 5.25 6.07 3.34l36.58-21.13zM46.13 1.21c69.29 8.69 138.41 12.96 207.36 12.93 68.95-.04 138.08-4.39 207.37-12.93l9.68-1.19v251.69l-9.68-1.18c-69.3-8.47-138.43-12.85-207.37-12.93-69.11-.07-138.22 4.15-207.33 12.89l-9.72 1.23V0l9.69 1.21zm207.36 30.14c-66.74.03-133.33-3.87-199.77-11.81v212.67c66.59-8.02 133.19-11.89 199.77-11.82 66.75.08 133.34 4.09 199.78 11.84V19.52c-66.44 7.82-133.03 11.79-199.78 11.83zm0 24.39c38.74 0 70.14 31.4 70.14 70.13S292.23 196 253.49 196c-38.73 0-70.13-31.4-70.13-70.13s31.4-70.13 70.13-70.13zm0 14.24c30.87 0 55.89 25.02 55.89 55.89s-25.02 55.89-55.89 55.89c-30.86 0-55.88-25.02-55.88-55.89s25.02-55.89 55.88-55.89zm187.24 244.77h50.75c11.29 0 20.52 9.23 20.52 20.51v76.67h-91.79v-76.67c0-11.28 9.23-20.51 20.52-20.51zm-264.48 0h-50.76c-11.28 0-20.51 9.23-20.51 20.51v76.67h91.78v-76.67c0-11.28-9.24-20.51-20.51-20.51zm-155.73 0h50.75c11.28 0 20.52 9.23 20.52 20.51v76.67H0v-76.67c0-11.28 9.23-20.51 20.52-20.51zm209.95 0h50.75c11.28 0 20.52 9.23 20.52 20.51v76.67h-91.79v-76.67c0-11.28 9.23-20.51 20.52-20.51zm155.72 0h-50.75c-11.28 0-20.51 9.23-20.51 20.51v76.67h91.78v-76.67c0-11.28-9.24-20.51-20.52-20.51zM73.16 265.71h50.75c11.29 0 20.52 9.24 20.52 20.52v15.02h-18.94c-9.36 0-17.87 3.82-24.03 9.98a34.45 34.45 0 0 0-3.08 3.53c-.94-1.24-1.97-2.43-3.08-3.53-6.16-6.16-14.66-9.98-24.03-9.98H52.64v-15.02c0-11.29 9.24-20.52 20.52-20.52zm155.73 0h-50.75c-11.29 0-20.52 9.24-20.52 20.52v15.02h18.63c9.36 0 17.87 3.82 24.03 9.98 1.1 1.1 2.13 2.28 3.07 3.53.95-1.25 1.98-2.43 3.08-3.53 6.16-6.16 14.67-9.98 24.04-9.98h18.93v-15.02c0-11.29-9.23-20.52-20.51-20.52zm54.22 0h50.75c11.29 0 20.52 9.24 20.52 20.52v15.02h-18.94c-9.36 0-17.87 3.82-24.03 9.98a34.45 34.45 0 0 0-3.08 3.53c-.94-1.24-1.97-2.43-3.08-3.53-6.16-6.16-14.66-9.98-24.03-9.98h-18.63v-15.02c0-11.29 9.24-20.52 20.52-20.52z" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="bg-[#222831] shadow-[#151515] shadow-md rounded-lg p-4">
                <h2 class="text-md font-base text-[#EEEEEE]">TOTAL SHOWS</h2>
                <div class="flex items-center justify-between">

                    <p class="text-3xl font-bold text-[#EEEEEE]" id="active-shows"><?= $TotalShows ?></p>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-[#DDE6ED]"
                            xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor" version="1.1"
                            id="Layer_1" viewBox="0 0 210.233 210.233" xml:space="preserve">
                            <g>
                                <g>
                                    <g>
                                        <path
                                            d="M33.736,86.705c3.297,2.671,7.267,3.969,11.214,3.969c5.206,0,10.366-2.258,13.891-6.608     c6.19-7.651,5.009-18.911-2.638-25.103c-3.703-3-8.336-4.379-13.101-3.881c-4.741,0.498-9.006,2.812-12.008,6.518     c-3.002,3.706-4.377,8.357-3.881,13.099C27.712,79.44,30.029,83.703,33.736,86.705z M37.261,66.591     c1.666-2.059,4.036-3.345,6.67-3.622c0.353-0.037,0.705-0.054,1.054-0.054c2.262,0,4.439,0.767,6.225,2.212     c4.246,3.44,4.904,9.696,1.464,13.945c-3.44,4.251-9.704,4.906-13.949,1.466c-2.057-1.668-3.347-4.036-3.622-6.67     C34.828,71.234,35.592,68.65,37.261,66.591z" />
                                        <path
                                            d="M113.468,134.565c-4.509-1.551-9.347-1.257-13.635,0.835c-4.284,2.09-7.499,5.723-9.053,10.232     c-1.554,4.509-1.255,9.353,0.833,13.635c2.092,4.286,5.725,7.501,10.234,9.053c1.902,0.656,3.866,0.982,5.826,0.982     c2.673,0,5.334-0.608,7.81-1.815c4.284-2.09,7.499-5.724,9.053-10.232s1.255-9.353-0.837-13.637     C121.611,139.334,117.977,136.118,113.468,134.565z M117.032,154.671c-0.86,2.506-2.646,4.524-5.028,5.685     c-2.382,1.161-5.063,1.33-7.577,0.463c-2.503-0.862-4.52-2.648-5.683-5.028c-1.162-2.38-1.325-5.071-0.461-7.575     c0.86-2.506,2.646-4.524,5.028-5.685c1.395-0.682,2.874-1.003,4.331-1.003c3.672,0,7.209,2.049,8.929,5.568     C117.733,149.477,117.896,152.167,117.032,154.671z" />
                                        <path
                                            d="M150.694,107c-2.526-4.044-6.477-6.86-11.125-7.935c-4.633-1.065-9.421-0.271-13.473,2.256     c-4.044,2.528-6.86,6.477-7.933,11.123c-2.212,9.589,3.789,19.192,13.38,21.408c1.344,0.31,2.688,0.459,4.013,0.459     c8.123,0,15.491-5.594,17.393-13.837C154.022,115.83,153.22,111.044,150.694,107z M145.217,118.691     c-1.228,5.324-6.551,8.652-11.892,7.432c-5.326-1.232-8.662-6.568-7.43-11.896c0.593-2.58,2.161-4.772,4.408-6.176     c1.596-0.998,3.397-1.511,5.233-1.511c0.748,0,1.503,0.085,2.251,0.256c2.58,0.597,4.776,2.163,6.178,4.41     C145.372,113.449,145.814,116.109,145.217,118.691z" />
                                        <path
                                            d="M52.403,112.444c-1.073-4.647-3.889-8.596-7.933-11.123c-4.044-2.527-8.832-3.33-13.473-2.255     c-4.649,1.073-8.6,3.889-11.125,7.933c-2.525,4.044-3.328,8.83-2.255,13.473c1.902,8.245,9.27,13.837,17.393,13.837     c1.325,0,2.669-0.147,4.013-0.459C48.615,131.636,54.615,122.033,52.403,112.444z M37.242,126.12     c-5.322,1.236-10.66-2.106-11.892-7.432c-0.597-2.58-0.155-5.239,1.251-7.484c1.402-2.247,3.599-3.814,6.178-4.408     c0.748-0.173,1.503-0.257,2.251-0.257c1.836,0,3.637,0.513,5.233,1.511c2.247,1.404,3.816,3.597,4.408,6.176     C45.903,119.554,42.568,124.891,37.242,126.12z" />
                                        <path
                                            d="M103.133,53.417c0-9.843-8.007-17.85-17.85-17.85s-17.85,8.007-17.85,17.85s8.007,17.85,17.85,17.85     S103.133,63.26,103.133,53.417z M85.283,63.333c-5.47,0-9.917-4.449-9.917-9.917c0-5.468,4.447-9.917,9.917-9.917     c5.47,0,9.917,4.449,9.917,9.917C95.2,58.884,90.753,63.333,85.283,63.333z" />
                                        <path
                                            d="M125.616,90.674c3.947,0,7.918-1.298,11.214-3.969c3.707-3.002,6.024-7.265,6.523-12.008     c0.496-4.741-0.879-9.394-3.881-13.099c-6.194-7.647-17.459-8.826-25.105-2.638c-7.651,6.194-8.832,17.455-2.642,25.105     C115.25,88.415,120.41,90.674,125.616,90.674z M119.356,65.127c4.257-3.446,10.509-2.783,13.949,1.464     c1.67,2.059,2.433,4.643,2.157,7.277c-0.275,2.634-1.565,5.003-3.622,6.67c-4.257,3.446-10.505,2.785-13.949-1.466     C114.452,74.823,115.111,68.567,119.356,65.127z" />
                                        <path
                                            d="M70.734,135.4c-4.288-2.092-9.127-2.388-13.635-0.835c-4.508,1.553-8.142,4.768-10.23,9.053     c-2.092,4.284-2.39,9.128-0.837,13.637c1.553,4.509,4.768,8.142,9.053,10.232c2.475,1.207,5.136,1.815,7.81,1.815     c1.956,0,3.924-0.325,5.826-0.982c4.509-1.551,8.142-4.767,10.23-9.051c2.092-4.284,2.39-9.128,0.837-13.637     C78.235,141.123,75.018,137.489,70.734,135.4z M71.818,155.793c-1.158,2.378-3.177,4.164-5.679,5.026     c-2.51,0.868-5.195,0.697-7.577-0.463c-2.382-1.16-4.168-3.178-5.028-5.685c-0.864-2.504-0.701-5.195,0.461-7.575     c1.72-3.519,5.257-5.568,8.929-5.568c1.457,0,2.936,0.322,4.331,1.003c2.382,1.16,4.168,3.178,5.028,5.685     C73.147,150.72,72.984,153.41,71.818,155.793z" />
                                        <path
                                            d="M210.209,185.862c-0.239-2.175-2.176-3.761-4.38-3.504c-32.059,3.517-44.853-33.426-45.384-35.001     c-0.135-0.403-0.371-0.734-0.61-1.059c6.817-12.251,10.733-26.328,10.733-41.315c0-47.025-38.257-85.283-85.283-85.283     C38.259,19.7,0,57.959,0,104.983c0,47.024,38.257,85.283,85.283,85.283c28.642,0,53.972-14.238,69.445-35.959     c4.734,10.535,19.118,36.226,46.808,36.226c1.674,0,3.397-0.095,5.167-0.292C208.88,190.001,210.449,188.039,210.209,185.862z      M85.283,182.333c-42.65,0-77.35-34.699-77.35-77.35s34.7-77.35,77.35-77.35c42.65,0,77.35,34.699,77.35,77.35     S127.933,182.333,85.283,182.333z" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </span>
                </div>
            </div>
        </div>


        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="shadow-md rounded-lg p-6 col-span-2 overflow-x-auto bg-[#222831]">
                <h2 class="text-center text-xl pt-3 pb-5 text-white">Latest Released Movies</h2>
                <?php


                $query = "
SELECT 
    m.movie_id, 
    m.title, 
    m.description, 
    m.duration, 
    m.release_date, 
    m.poster_url, 
    GROUP_CONCAT(g.genre_name ORDER BY g.genre_name ASC) AS genres,
    COALESCE(FORMAT(AVG(r.rating), 1), '0.0') AS average_rating
FROM 
    movies m
JOIN 
    movie_genres mg ON m.movie_id = mg.movie_id
JOIN 
    genres g ON mg.genre_id = g.genre_id
LEFT JOIN 
    reviews r ON m.movie_id = r.movie_id
GROUP BY 
    m.movie_id
ORDER BY 
    m.release_date DESC
LIMIT 5;

";

                $stmt = $conn->prepare($query);
                $stmt->execute();
                $stmt->bind_result($movie_id, $title, $description, $duration, $release_date, $poster_url, $genres, $average_rating);

                ?>
                <table
                    class="min-w-full divide-y-2 divide-gray-200 text-sm divide-gray-700 ">
                    <thead class="text-left">
                        <tr>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-white">
                                Poster
                            </th>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-white">
                                Movie Name</th>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-white">
                                Genre</th>
                            <th class="whitespace-nowrap px-4 py-2 font-medium text-white">
                                Rating</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 divide-gray-700">
                        <?php

                        while ($stmt->fetch()) {
                            echo "<tr>";
                            echo "<td class='whitespace-nowrap px-4 py-2  text-gray-200'>
            <img alt='Poster' src='../views/$poster_url' class='size-10 rounded-md object-cover' />
          </td>";
                            echo "<td class='whitespace-nowrap px-4 py-2 font-medium text-white'>$title</td>";
                            echo "<td class='whitespace-nowrap px-4 py-2  text-gray-200'>$genres</td>";
                            echo "<td class='whitespace-nowrap px-4 py-2  text-gray-200'>$average_rating/10</td>";
                            echo "<td class='whitespace-nowrap px-4 py-2'>
            <a href='../views/movie.php?id=$movie_id' class='inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700'>
                View
            </a>
          </td>";
                            echo "</tr>";
                        }

                        $stmt->close();
                        ?>
                    </tbody>
                </table>
            </div>


            <div class="shadow-md rounded-lg p-6 bg-[#222831]">
                <h2 class="text-center text-xl py-5">Weekly New Users</h2>
                <canvas id="showChart"></canvas>
            </div>
        </div>
    </main>
</div>
</div>

<script>
    const showChartCtx = document.getElementById('showChart').getContext('2d');
    const showChart = new Chart(showChartCtx, {
        type: 'pie',
        data: {
            labels: ['Today', '3 Days', '7 Days'],
            datasets: [{
                label: 'TOTAL ',
                data: [<?= $OneDayNewUsers ?>, <?= $ThreeDayNewUsers ?>, <?= $SevenDayNewUsers ?>],
                backgroundColor: [
                    'rgba(225, 78, 95, 0.7)',
                    'rgba(45, 140, 210, 0.7)',
                    'rgba(245, 180, 60, 0.7)'
                ]
            }]

        }
    });
</script>
</body>

</html>