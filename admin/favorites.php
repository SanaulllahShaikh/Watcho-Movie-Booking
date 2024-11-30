<?php
$active_tab = 'favorites';
include './includes/header.php';
?>

<div class="flex-grow px-6">
    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">USER FAVORITES</h1>
            <div class="relative">
                <input type="text" id="searchFavorite" placeholder="Search by movie title"
                    class="w-80 py-2 pr-16 pl-6 rounded-full border border-gray-700 bg-[#222831] text-white placeholder-gray-400 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#CC2B52]">
                <button
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 text-[#CC2B52] h-full pl-4 pr-6 rounded-r-full transition duration-300 hover:bg-[#CC2B52] hover:text-white ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 " viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="mt-4">
            <table class="min-w-full text-white">
                <thead class="py-2">
                    <tr>
                        <th class="py-3 px-4 text-center text-xs font-normal">Favorite ID</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">User id (username)</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">Movie Title</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">Added Date</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">Actions</th>
                    </tr>
                </thead>
                <tbody id="favoritesBody">
                </tbody>
            </table>
        </div>
    </main>
</div>

<script>
    $.ajax({
        url: './controllers/fetch_favorites.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#favoritesBody').empty();

            if (data.length <= 0) {
                let favoriteRow = `
                        <tr>
                         <td class="py-5 px-4 text-center text-md" colspan="5">No favorites found</td>
                        </tr>
                    `;
                $('#favoritesBody').append(favoriteRow);
            }

            data.forEach(function(favorite) {
                const favoriteRow = `
        <tr class="bg-[#021526]" id="favoriteRow${favorite.favorite_id}">
            <td class="py-5 px-4 text-center text-md">${favorite.favorite_id}</td>
            <td class="py-5 px-4 text-start text-md">${favorite.user_id}>${favorite.user_name}</td>
            <td class="py-5 px-4 text-center text-md">${favorite.movie_title}</td>
            <td class="py-5 px-4 text-center text-md">${favorite.added_date}</td>
            <td class="py-5 px-4 space-x-2 flex items-center justify-center">
                <button onclick="removeFavorite(${favorite.favorite_id})" class="bg-[#821131] text-[#CC2B52] p-1 rounded-md transition duration-300 hover:bg-[#800000]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6 19C6 20.1046 6.89543 21 8 21H16C17.1046 21 18 20.1046 18 19V7H6V19ZM16 4H14.5L13.5 3H10.5L9.5 4H8V6H16V4Z"></path>
                    </svg>
                </button>   
            </td>
        </tr>
    `;
                $('#favoritesBody').append(favoriteRow);
            });

            document.getElementById("searchFavorite").addEventListener("input", function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll("#favoritesBody tr");

                rows.forEach((row) => {
                    const movieTitle = row.children[2].textContent.toLowerCase();
                    if (movieTitle.includes(searchValue)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });

        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', error);
        }
    });

    function removeFavorite(favoriteId) {
        if (confirm("Are you sure you want to remove this favorite?")) {
            $.ajax({
                url: './controllers/delete_favorite.php',
                method: 'POST',
                data: {
                    favorite_id: favoriteId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $(`#favoriteRow${favoriteId}`).fadeOut();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', error);
                    alert("An error occurred while trying to remove the favorite.");
                }
            });
        }
    }
</script>
</body>

</html>