<?php
$active_tab = '';
include './includes/header.php';

?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">UPLOAD GENRE</h1>
            <a href="./genres.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Genres List
            </a>
        </div>

        <div class="border border-gray-800 p-8 rounded-xl mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            <div class="inputs col-span-2">
                <form id="uploadGenreForm" class="space-y-6 min-h-[60vh] flex flex-col justify-center">
                    <input
                        type="text"
                        name="genre_name"
                        placeholder="Genre Name"
                        class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]"
                        required>
                    <p class="text-sm mt-1 text-gray-400">
                        Add multiple genres separated by spaces (e.g., Action Adventure).
                    </p>

                    <div class="flex justify-end mt-4">
                        <button
                            type="submit"
                            class="bg-[#1D267D] text-[#DDE6ED] py-2 px-5 rounded-full transition duration-300 hover:bg-[#2F58CD]">
                            ADD GENRE
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
    $('#uploadGenreForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: './controllers/upload_genre.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                const feedbackDiv = $('#feedback');
                feedbackDiv.removeClass('hidden');
                if (data.success) {
                    feedbackDiv
                        .removeClass('bg-red-600')
                        .addClass('bg-green-600 text-white')
                        .text('Genres added successfully!');
                    $('#uploadGenreForm')[0].reset();
                    setTimeout(() => {
                        window.location.href = "./genres.php";
                    }, 1500);
                } else {
                    feedbackDiv
                        .removeClass('bg-green-600')
                        .addClass('bg-red-600 text-white')
                        .text(data.error || 'An error occurred while adding genres.');
                }
            },
            error: function() {
                const feedbackDiv = $('#feedback');
                feedbackDiv
                    .removeClass('hidden')
                    .removeClass('bg-green-600')
                    .addClass('bg-red-600 text-white')
                    .text('Failed to connect to the server. Please try again.');
            },
        });
    });
</script>
</body>

</html>