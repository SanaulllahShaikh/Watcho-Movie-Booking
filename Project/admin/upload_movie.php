<?php
$active_tab = '';
include './includes/header.php';

?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">UPLOAD MOVIE</h1>
            <a href="./index.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Dashboard
            </a>
        </div>
        <div class="flex py-2 justify-center">
            <div id="error_messages" class="mt-4 text-md text-medium text-red-700"></div>
        </div>
        <form method="POST" enctype="multipart/form-data" id="uploadMovieForm" class="border border-gray-800 p-8 rounded-xl mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="media col-span-2 lg:col-span-1 justify-center items-center">
                <input type="file" id="movie_poster" name="movie_poster" class="hidden">
                <label for="movie_poster" id="poster_label" class="w-full h-[200px] lg:h-[500px] rounded-xl flex items-center justify-center bg-[#222831] text-center text-white font-medium cursor-pointer">
                    Upload Poster
                </label>
            </div>

            <div class="inputs col-span-2 space-y-6">
                <input type="text" id="movie_title" name="movie_title" placeholder="Title" class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                <textarea id="movie_description" name="movie_description" placeholder="Description" rows="4" class="w-full py-3 px-5 rounded-lg border border-gray-300 border-gray-600 bg-[#222831] resize-none"></textarea>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="">
                        <label for="release_date" class="ml-4 text-gray-300">Release Date</label>
                        <input type="date" id="release_date" name="release_date" placeholder="Release Date mm/dd/yyyy" class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831] col-span-1">
                    </div>
                    <div class="col-span-2">
                        <label for="release_date" class="ml-4 text-gray-300">Genre</label>
                        <input type="text" id="movie_genre" name="movie_genre" placeholder="Genres" class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                    </div>
                    <input type="text" id="movie_duration" name="movie_duration" placeholder="Duration in minutes" class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831] col-span-3">
                </div>

                <div class="grid lg:grid-cols-1 w-full gap-2">
                    <label for="upload_trailer" class="cursor-pointer w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">Upload Trailer</label>
                    <input type="file" id="upload_trailer" name="upload_trailer" class="cursor-pointer w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831] hidden">
                    <label for="upload_banner" id="banner_label" class="cursor-pointer w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">Upload Banner</label>
                    <input type="file" id="upload_banner" name="upload_banner" class="cursor-pointer w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831] hidden">
                </div>

                <div class="flex justify-end mt-3 w-full">
                    <button id="upload_button" type="submit" class="bg-[#1D267D] text-[#DDE6ED] py-2 px-5 rounded-full transition duration-300 hover:bg-[#2F58CD]">UPLOAD</button>
                </div>
            </div>
        </form>

    </main>
</div>
</div>


<script>
    document.getElementById('movie_poster').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const label = document.getElementById('poster_label');
                label.style.backgroundImage = `url('${e.target.result}')`;
                label.style.backgroundSize = 'cover';
                label.style.backgroundPosition = 'center';
                label.textContent = '';
            };
            reader.readAsDataURL(file);
        }
    });
    document.getElementById('upload_banner').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const label = document.getElementById('banner_label');
                label.style.backgroundImage = `url('${e.target.result}')`;
                label.style.backgroundSize = 'cover';
                label.style.backgroundPosition = 'center';
                label.textContent = '';
                label.style.minHeight = '200px';
                label.style.borderRadius = '0px';
            };
            reader.readAsDataURL(file);
        }
    });
    $('#uploadMovieForm').submit(function(e) {
        e.preventDefault();
        $('upload_button').disabled = true;

        $('#error_messages').html('');

        var formData = new FormData(this);

        $.ajax({
            url: './controllers/upload_movie.php',
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