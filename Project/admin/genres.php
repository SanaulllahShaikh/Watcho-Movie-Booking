<?php
$active_tab = 'genres';
include './includes/header.php';

?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">ALL GENRES</h1>
            <a href="./upload_genre.php" class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Add
            </a>
        </div>
        <div class="my-2">
            <div class="relative">
                <input type="text" id="searchGenre" placeholder="Search genre by name"
                    class="w-full py-3 pr-16 pl-6 rounded-full border border-gray-700 bg-[#222831] text-white placeholder-gray-400 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#CC2B52]">
                <button
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 text-[#CC2B52] h-full pl-4 pr-6 rounded-r-full transition duration-300  hover:bg-[#CC2B52]  hover:text-white ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 " viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="mt-4">
            <div class="text-end p-4">
                <a href="./link_genre.php" class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                    Link Genre to Movie
                </a>
            </div>
            <table class="min-w-full text-white">
                <thead class="py-2">
                    <tr>
                        <th class="py-3 px-4 text-center text-xs font-normal">ID</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">GENRE NAME</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">NUMBER OF MOVIES</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="genreBody">
                    <tr class="bg-[#021526]">
                        <td class="py-5 px-4 text-center text-md">1</td>
                        <td class="py-5 px-4 text-center text-md">Action</td>
                        <td class="py-5 px-4 text-center text-md">12</td>
                        <td class="py-5 px-4 space-x-2 flex items-center justify-center">

                            <button
                                class="bg-[#00337C] text-[#1C82AD] p-1 rounded-md transition duration-300 hover:bg-[#13005A] hover:text-[#1C82AD]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M15.728 9.576L14.314 8.162 5 17.476v1.414h1.414l9.314-9.314ZM17.142 8.162l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414ZM7.243 20.89H3v-4.243L16.435 3.212c.391-.39 1.024-.39 1.414 0l2.829 2.829c.39.39.39 1.024 0 1.414L7.243 20.89Z"></path>
                                </svg>
                            </button>
                            <button
                                class="bg-[#821131] text-[#CC2B52] p-1 rounded-md transition duration-300 hover:bg-[#800000]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3Zm1 2H6v12h12V8ZM9 11h2v6H9v-6Zm4 0h2v6h-2v-6ZM9 4v2h6V4H9Z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </main>
</div>
</div>
<script>
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
                    <button onclick="deleteGenre(${id})" class="px-8 w-full py-3 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
                    <button onclick="closeModal()" class="px-8 w-full py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Dismiss</button>
                </div>
            `;
                break;
            case "edit":
                titleTag = `<h2 class="text-xl font-semibold text-blue-500 w-full">${title}</h2>`;
                descriptionTag = `
                <form id="editGenreForm" class="mt-4 flex flex-col w-full space-y-4">
                    <label for="genreName" class="text-gray-700">Genre Name</label>
                    <input type="text" id="genreName" class="border border-gray-300 rounded-lg px-4 py-2" placeholder="Enter genre name" required>
                </form>
            `;
                actionButtons = `
                <div class="flex w-full justify-around gap-4 mt-6">
                    <button onclick="updateGenre(${id})" class="px-8 w-full py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Save</button>
                    <button onclick="closeModal()" class="px-8 w-full py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Cancel</button>
                </div>
            `;
                break;
            default:
                titleTag = `<h2 class="text-lg font-bold w-full">${title}</h2>`;
                descriptionTag = `<p class="mt-4 text-gray-600 w-full py-2">${description}</p>`;
                actionButtons = `
                <div class="flex justify-center w-full mt-6">
                    <button onclick="closeModal('reload')" class="px-6 py-2 w-full bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">OK</button>
                </div>
            `;
                break;
        }

        modal.id = 'info-modal';
        modal.className = 'fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 overflow-hidden z-50';
        modal.innerHTML = `
        <div class="bg-white w-11/12 md:w-1/2 p-8 flex flex-col justify-center items-center rounded-lg shadow-lg">
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

    function closeModal(type) {
        if (type === 'reload') {
            const modal = document.getElementById('info-modal');
            modal.remove();
            document.body.style.overflow = '';
            location.reload();
            return
        }
        const modal = document.getElementById('info-modal');
        if (modal) {
            modal.remove();
        }

        document.body.style.overflow = '';
    }

    function updateGenre(genre_id) {
        let newGenreName = $('#genreName').val();
        console.log(newGenreName);
        $.ajax({
            url: './controllers/update_genre.php',
            type: 'POST',
            dataType: 'json',
            data: {
                genre_id: genre_id,
                genre_name: newGenreName
            },
            success: function(response) {
                if (response.success) {
                    openModal("Genre Updated", "The genre has been successfully updated.");
                } else {
                    alert("Failed to delete genre: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error deleting genre: ", status, error);
                alert("An error occurred. Please try again.");
            }
        });

        closeModal();
    }

    function deleteGenre(genre_id) {
        $.ajax({
            url: './controllers/delete_genre.php',
            type: 'POST',
            dataType: 'json',
            data: {
                genre_id: genre_id
            },
            success: function(response) {
                if (response.success) {
                    openModal("Genre Deleted", "The genre has been successfully deleted.");
                } else {
                    alert("Failed to delete genre: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error deleting genre: ", status, error);
                alert("An error occurred. Please try again.");
            }
        });

        closeModal();
    }



    $.ajax({
        url: './controllers/fetch_genres.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response['success']) {
                const genres = response['data'];
                console.log(genres);

                const tbody = $("#genreBody");

                tbody.empty();

                genres.forEach((genre, index) => {
                    const row = `
                    <tr class="bg-[#021526]" id="genreRow_${genre.id}" data-name='${genre.name}'>
                        <td class="py-5 px-4 text-center text-md">${index + 1}</td>
                        <td class="py-5 px-4 text-center text-md">${genre.name}</td>
                        <td class="py-5 px-4 text-center text-md">${genre.movies_count}</td>
                        <td class="py-5 px-4 space-x-2 flex items-center justify-center">
<button
    class="flex items-center gap-1 bg-blue-600 text-white p-2 rounded-md transition duration-300 hover:bg-blue-700"
    onclick="openModal('${genre.name}', 'Edit genre', 'edit', '${genre.id}')">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
        <path d="M15.728 9.576L14.314 8.162 5 17.476v1.414h1.414l9.314-9.314ZM17.142 8.162l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414ZM7.243 20.89H3v-4.243L16.435 3.212c.391-.39 1.024-.39 1.414 0l2.829 2.829c.39.39.39 1.024 0 1.414L7.243 20.89Z"></path>
    </svg>
</button>

<button onclick="openModal('Are you sure...', 'you want to delele this genre &quot;${genre.name}&quot;', 'danger', '${genre.id}')"
    class="flex items-center gap-1 bg-red-600 text-white p-2 rounded-md transition duration-300 hover:bg-red-700">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
        <path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3Zm1 2H6v12h12V8ZM9 11h2v6H9v-6Zm4 0h2v6h-2v-6ZM9 4v2h6V4H9Z"></path>
    </svg>
</button>

                        </td>
                    </tr>
                `;
                    tbody.append(row);
                });
                document.getElementById("searchGenre").addEventListener("input", function() {
                    const searchValue = this.value.toLowerCase();
                    const rows = document.querySelectorAll("#genreBody tr");

                    rows.forEach((row) => {
                        const name = row.getAttribute("data-name").toLowerCase();
                        if (name.includes(searchValue)) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });
                });
            } else {
                console.error('Error:', response.message);
                alert('Failed to fetch genres.');
            }

        },
        error: function(xhr, status, error) {
            console.error('Error fetching genres:', error);
            alert('An unexpected error occurred.');
        }
    });
</script>
</body>

</html>