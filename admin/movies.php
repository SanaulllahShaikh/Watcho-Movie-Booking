<?php
$active_tab = 'movies';
include './includes/header.php';

?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">ALL MOVIES</h1>
            <a href="./upload_movie.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Upload
            </a>
        </div>
        <div class="my-2">
            <div class="relative">
                <input type="text" id="searchMovie" placeholder="Search Movie By Title"
                    class="w-full py-3 pr-16 pl-6 rounded-full border border-gray-700 bg-[#222831] text-white placeholder-gray-400 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#CC2B52]">
                <button
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 text-[#CC2B52] h-full pl-4 pr-6 rounded-r-full transition duration-300  hover:bg-[#CC2B52]  hover:text-white ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 " viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="mt-4">
            <table class="min-w-full text-white">
                <thead class="py-2">
                    <tr>
                        <th class="py-3 px-4 text-center text-xs font-normal">ID</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">TITLE</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">GENRES</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">DURATION</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">RELEASE DATE</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">STATUS</th>

                        <th class="py-3 px-4 text-center text-xs font-normal">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="moviesBody">
                    <tr class="bg-[#021526]">
                        <td class="py-5 px-4 text-center text-md">1</td>
                        <td class="py-5 px-4 text-center text-md">The Dark Knight</td>
                        <td class="py-5 px-4 text-center text-md">Action, Crime</td>
                        <td class="py-5 px-4 text-center text-md">152 mins</td>
                        <td class="py-5 px-4 text-center text-md">2008-07-18</td>
                        <td class="py-5 px-4 space-x-2 flex items-center justify-center">
                            <button onclick="openModal('Information about movie', '', 'info')"
                                class="bg-[#1E5128] text-[#03C988] p-1 rounded-md transition duration-300 hover:bg-[#3B5249]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z">
                                    </path>
                                </svg>
                            </button>
                            <button
                                class="bg-[#00337C] text-[#1C82AD] p-1 rounded-md transition duration-300 hover:bg-[#13005A] hover:text-[#1C82AD]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M15.7279 9.57627L14.3137 8.16206L5 17.4758V18.89H6.41421L15.7279 9.57627ZM17.1421 8.16206L18.5563 6.74785L17.1421 5.33363L15.7279 6.74785L17.1421 8.16206ZM7.24264 20.89H3V16.6473L16.435 3.21231C16.8256 2.82179 17.4587 2.82179 17.8492 3.21231L20.6777 6.04074C21.0682 6.43126 21.0682 7.06443 20.6777 7.45495L7.24264 20.89Z">
                                    </path>
                                </svg>
                            </button>
                            <button onclick="openModal('Are you sure...', 'you want to delete this \'John wick chapter 4\'?', 'danger')"
                                class="bg-[#821131] text-[#CC2B52] p-1 rounded-md transition duration-300 hover:bg-[#800000]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z">
                                    </path>
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
        $.ajax({
            url: './controllers/delete_movie.php',
            type: 'POST',
            dataType: 'json',
            data: {
                movie_id: movie_id
            },
            success: function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    alert('Failed to delete movie', response);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error deleting movie: ", status, error);
                alert('An error occurred. Please try again.');
            }
        });

        closeModal();
    }
    $.ajax({
        url: './controllers/fetch_movies.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#moviesBody').empty();

            data.forEach(movie => {
                $('#moviesBody').append(`
<tr class="bg-[#021526]" data-title="${movie.title}">
    <td class="py-5 px-4 text-center text-md">${movie.id}</td>
    <td class="py-5 px-4 text-center text-md">${movie.title}</td>
    <td class="py-5 px-4 text-center text-md">${movie.genres}</td>
    <td class="py-5 px-4 text-center text-md">${movie.duration} mins</td>
    <td class="py-5 px-4 text-center text-md">${movie.release_date}</td>
    <td class="py-5 px-4 text-center text-md">
    ${movie.is_published == 1 ? 'Published' : 'Not Published'}
    </td>
    <td class="py-5 px-4 space-x-2 flex items-center justify-center">
        <button onclick="openModal('Information about ${movie.title}', '[${movie.id}, ${movie.title}, ${movie.genres}, ${movie.release_date}, ${movie.duration}]', 'info')"
            class="bg-[#1E5128] text-[#03C988] p-1 rounded-md transition duration-300 hover:bg-[#3B5249]">
            <!-- View Details Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z"></path>
            </svg>
        </button>
        <button onclick='window.location.href="./edit_movie.php?movie_id=${movie.id}";'
            class="bg-[#00337C] text-[#1C82AD] p-1 rounded-md transition duration-300 hover:bg-[#13005A] hover:text-[#1C82AD]">
            <!-- Edit Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M15.7279 9.57627L14.3137 8.16206L5 17.4758V18.89H6.41421L15.7279 9.57627ZM17.1421 8.16206L18.5563 6.74785L17.1421 5.33363L15.7279 6.74785L17.1421 8.16206ZM7.24264 20.89H3V16.6473L16.435 3.21231C16.8256 2.82179 17.4587 2.82179 17.8492 3.21231L20.6777 6.04074C21.0682 6.43126 21.0682 7.06443 20.6777 7.45495L7.24264 20.89Z"></path>
            </svg>
        </button>
        <button onclick="openModal('Are you sure...', 'you want to delete this &quot;${movie.title}&quot;?', 'danger', '${movie.id}')"
            class="bg-[#821131] text-[#CC2B52] p-1 rounded-md transition duration-300 hover:bg-[#800000]">
            <!-- Delete Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z"></path>
            </svg>
        </button>
    </td>
</tr>

                `);
            });
            document.getElementById("searchMovie").addEventListener("input", function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll("#moviesBody tr");

                rows.forEach((row) => {
                    const title = row.getAttribute("data-title").toLowerCase();
                    if (title.includes(searchValue)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching movies:', error);
        }
    });
</script>
</body>

</html>