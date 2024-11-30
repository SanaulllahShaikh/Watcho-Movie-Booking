<?php
$active_tab = '';
include './includes/header.php';

include_once '../controllers/config.php';
$movies_result = $conn->query("SELECT movie_id, title as movie_title FROM movies");
$movie_id = isset($_GET['movie_id']) ? intval($_GET['movie_id']) : 0;

$genres_result = $conn->query("SELECT genre_id, genre_name FROM genres");


?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">Link Genre with movie</h1>
            <a href="./movies.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Movies List
            </a>
        </div>

        <div class="border border-gray-800 p-8 rounded-xl mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            <div class="inputs col-span-2">
                <form id="linkGenreForm" class="space-y-6 min-h-[60vh] flex flex-col justify-center" method="POST">
                    <div class="space-y-4">
                        <label for="movie" class="text-gray-700">Select Movie</label>
                        <select id="movie" name="movie_id" class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]" required>
                            <option value="">Select a Movie</option>
                            <?php while ($movie = $movies_result->fetch_assoc()) : ?>
                                <option value="<?= $movie['movie_id']; ?>"><?= $movie['movie_title']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="space-y-4">
                        <label for="genre" class="text-gray-700">Select Genre(s)</label>
                        <select id="genre" name="genre_ids[]" class="w-full py-3 px-5 rounded-sm border border-gray-300 border-gray-600 bg-[#222831]" multiple required>
                            <?php while ($genre = $genres_result->fetch_assoc()) : ?>
                                <option value="<?= $genre['genre_id']; ?>"><?= $genre['genre_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <p class="text-sm mt-1 text-gray-400">
                            Hold down <strong>Ctrl</strong> (or <strong>Cmd</strong> on Mac) to select multiple genres.
                        </p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" id="submitForm" class="bg-[#1D267D] text-[#DDE6ED] py-2 px-5 rounded-full transition duration-300 hover:bg-[#2F58CD]">
                            LINK GENRE
                        </button>
                    </div>
                </form>

                <div id="feedback" class="mt-4 hidden p-4 rounded-lg"></div>

            </div>
        </div>
    </main>

</div>
</div>
<script>
    $(document).ready(function() {

        $('#movie').on('change', function() {
            let movieId = $(this).val();

            if (movieId) {
                $.ajax({
                    url: 'get_linked_genres.php',
                    method: 'GET',
                    dataType: 'JSON',
                    data: {
                        movie_id: movieId
                    },
                    success: function(response) {
                        $('#genre option').each(function() {
                            let genreId = $(this).val();
                            if (response['linked_genres'].includes(genreId)) {
                                $(this).prop('disabled', true).prop('selected', true);
                            } else {
                                $(this).prop('disabled', false).prop('selected', false);
                            }
                        });
                    }
                });
            } else {
                $('#genre option').prop('disabled', false).prop('selected', false);
            }
        });



        $('#submitForm').on('click', function(e) {
            e.preventDefault();

            var movieId = $('#movie').val();
            var genreIds = $('#genre').val();

            if (!movieId || !genreIds || genreIds.length === 0) {
                $('#feedback').removeClass('hidden').addClass('bg-red-500').text('Please select both a movie and genre(s).').fadeIn();
                return;
            }

            var formData = {
                movie_id: movieId,
                genre_ids: genreIds
            };

            $.ajax({
                url: './controllers/link_genre_movie.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#feedback').removeClass('hidden').addClass('bg-green-500').text(`${response.message} Already linked : ${response.already_linked} | Newly linked : ${response.newly_added}`).fadeIn();
                        $('#linkGenreForm')[0].reset();
                    } else {
                        $('#feedback').removeClass('hidden').addClass('bg-red-500').text(response.error).fadeIn();
                    }
                },
                error: function() {
                    $('#feedback').removeClass('hidden').addClass('bg-red-500').text('An error occurred. Please try again later.').fadeIn();
                }
            });
        });
    });
</script>
</body>

</html>