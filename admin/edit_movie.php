<?php
$active_tab = '';
include './includes/header.php';
include_once '../controllers/config.php';
$movie_id = $_GET['movie_id'];

$query = "
SELECT 
    m.movie_id, 
    m.title, 
    m.duration, 
    m.description, 
    m.poster_url, 
    m.banner_url, 
    m.release_date,
    m.is_published,
    GROUP_CONCAT(g.genre_name ORDER BY g.genre_name ASC) AS genres 
FROM 
    movies m
LEFT JOIN 
    movie_genres mg ON m.movie_id = mg.movie_id
LEFT JOIN 
    genres g ON mg.genre_id = g.genre_id
WHERE 
    m.movie_id = ?
GROUP BY 
    m.movie_id, m.title, m.duration, m.release_date
ORDER BY 
    m.release_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();
$poster_url = '';
if (str_starts_with($movie['poster_url'], 'http')) {
    $poster_url = $movie['is_published'];
} else {
    $poster_url = '../views/' . $movie['poster_url'];
}
$banner_url = '';
if (str_starts_with($movie['banner_url'], 'http')) {
    $banner_url = $movie['banner_url'];
} else {
    $banner_url = '../views/' . $movie['banner_url'];
}


?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">EDIT MOVIE</h1>
            <a href="./movies.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Movies
            </a>
        </div>
        <div class="flex py-2 justify-center">
            <div id="error_messages" class="mt-4 text-md text-medium text-red-700"></div>
        </div>
        <form method="POST" enctype="multipart/form-data" id="updateMovieForm" class="border border-gray-800 p-8 rounded-xl mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <input type="hidden" id="movie_id" name="movie_id" value="<?= $movie_id ?>">

            <div class="media col-span-2 lg:col-span-1 justify-center items-center">
                <input type="file" id="movie_poster" name="movie_poster" class="hidden">
                <label for="movie_poster" id="poster_label" class="w-full h-[200px] lg:h-[500px] rounded-xl flex items-center justify-center bg-[#222831] text-center text-white font-medium cursor-pointer">
                    Upload Poster
                </label>
                <?php if (!empty($movie['poster_url'])): ?>
                    <p class="text-center mt-4">Current Poster</p>
                    <img src="<?= $poster_url ?>" alt="Current Poster" class="mt-4 w-full h-[200px] lg:h-[500px] rounded-xl object-cover">
                <?php endif; ?>
            </div>

            <div class="inputs col-span-2 space-y-6">
                <input type="text" id="movie_title" name="movie_title" placeholder="Title" value="<?= htmlspecialchars($movie['title']) ?>" class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">

                <textarea id="movie_description" name="movie_description" placeholder="Description" rows="4" class="w-full py-3 px-5 rounded-lg border border-gray-300 border-gray-600 bg-[#222831] resize-none"><?= htmlspecialchars($movie['description']) ?></textarea>
                <div class="flex flex-col ml-4">
                    <label for="privacy" class="mb-2">Published</label>
                    <div>
                        <label for="pr1">Yes</label>
                        <input type="radio" id="privacy pr1" name="publish" value="1"
                            class="ml-1 size-4 py-5 px-5 pl-2 rounded-lg border border-gray-300 border-gray-600 bg-[#222831] resize-none"
                            <?php echo ($movie['is_published'] == 1) ? 'checked' : ''; ?>>

                        <label for="pr2" class="ml-4">No</label>
                        <input type="radio" id="privacy pr2" name="publish" value="0"
                            class="ml-1 size-4 py-5 px-5 pl-2 rounded-lg border border-gray-300 border-gray-600 bg-[#222831] resize-none"
                            <?php echo ($movie['is_published'] == 0) ? 'checked' : ''; ?>>
                    </div>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="release_date" class="ml-4 text-gray-300">Release Date</label>
                        <input type="date" id="release_date" name="release_date" value="<?= $movie['release_date'] ?>" class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                    </div>
                    <div class="col-span-2">
                        <label for="movie_genre" class="ml-4 text-gray-300">Genre</label>
                        <input type="text" id="movie_genre" name="movie_genre" value="<?= htmlspecialchars($movie['genres']) ?>" class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                    </div>
                    <input type="text" id="movie_duration" name="movie_duration" value="<?= $movie['duration'] ?>" placeholder="Duration in minutes" class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831] col-span-3">
                </div>

                <div class="grid lg:grid-cols-1 w-full gap-2">
                    <label for="upload_trailer" class="cursor-pointer w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">Upload Trailer</label>
                    <input type="file" id="upload_trailer" name="upload_trailer" class="cursor-pointer w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831] hidden">
                    <?php if (!empty($movie['trailer_url'])): ?>
                        <p class="text-gray-300 mt-2">Current Trailer: <a href="<?= $movie['trailer_url'] ?>" class="text-blue-500 underline" target="_blank">View Trailer</a></p>
                    <?php endif; ?>

                    <label for="upload_banner" id="banner_label" class="cursor-pointer w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">Upload Banner</label>
                    <input type="file" id="upload_banner" name="upload_banner" class="cursor-pointer w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831] hidden">
                    <?php if (!empty($movie['banner_url'])): ?>
                        <p class="text-center mt-2">Current Banner</p>
                        <img src="<?= $banner_url ?>" alt="Current Banner" class="mt-4 w-full rounded-xl object-cover">
                    <?php endif; ?>
                </div>

                <div class="flex justify-end mt-3 w-full">
                    <button id="upload_button" type="submit" class="bg-[#1D267D] text-[#DDE6ED] py-2 px-5 rounded-full transition duration-300 hover:bg-[#2F58CD]">UPDATE MOVIE</button>
                </div>
            </div>
        </form>


    </main>
</div>
</div>


<script>
    $('#updateMovieForm').submit(function(e) {
        e.preventDefault();
        $('upload_button').disabled = true;

        $('#error_messages').html('');

        var formData = new FormData(this);

        $.ajax({
            url: './controllers/update_movie.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.status == 'success') {
                    $('upload_button').disabled = true;
                    $('#error_messages').html(response.message);
                    setTimeout(() => {
                        window.location.href = "./index.php";
                    }, 1500);
                } else {
                    $('upload_button').disabled = false;
                    $('#error_messages').html(response.message);
                }
            },
            error: function(xhr, status, error) {
                $('upload_button').disabled = false;
                console.error('Error:', error);
                $('#error_messages').html('An error occurred while uploading the movie.');
            }
        });
    });
</script>
</body>

</html>