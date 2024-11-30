<?php
$active_tab = 'cinemas';
include './includes/header.php';

?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">ALL CINEMA</h1>
            <a href="./upload_cinema.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                New cinema
            </a>
        </div>
        <div id="cinemas-grid" class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-white">

            <div class="cinema bg-[#021526] h-[500px] relative rounded-xl">
                <div class="inner p-6 w-full h-full flex flex-col justify-between">
                    <div class="flex justify-center items-center w-full my-5">
                        <h3 class="cinema-name text-lg font-medium text-white py-2">ISLAMABAD Cinema</h3>
                    </div>
                    <span class="cinema-type font-semibold text-2xl text-center py-4 rounded-full">IMAX</span>
                    <div class="my-2 flex flex-col gap-3">
                        <button onclick="openModal('Are you sure...', 'you want to delete this cinema \'ISLAMABAD Cinema\'', 'danger')"
                            class="flex w-full justify-center items-center gap-2 rounded border border-red-500 px-8 py-4 text-red-500 hover:bg-red-500 hover:text-white focus:outline-none focus:ring active:bg-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1zM5 4a1 1 0 00-1 1v11a2 2 0 002 2h6a2 2 0 002-2V5a1 1 0 00-1-1H5zm7 2a1 1 0 00-2 0v7a1 1 0 002 0V6zm-4 0a1 1 0 00-2 0v7a1 1 0 002 0V6z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium">DELETE</span>
                        </button>
                        <button
                            onclick="window.location.href = './edit_cinema.php'"
                            class="flex w-full justify-center items-center gap-2 rounded border border-yellow-500 px-8 py-4 text-yellow-500 hover:bg-yellow-500 hover:text-white focus:outline-none focus:ring active:bg-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M17.414 2.586a2 2 0 010 2.828l-9.828 9.828a2 2 0 01-1.263.732l-4 1a1 1 0 01-1.212-1.212l1-4a2 2 0 01.732-1.263l9.828-9.828a2 2 0 012.828 0zm-5.828 3.414l-8.585 8.586-.293 1.171 1.171-.293 8.586-8.585-1.707-1.707zm2.121-2.121l-1.414 1.414 1.707 1.707 1.414-1.414-1.707-1.707z" />
                            </svg>
                            <span class="text-sm font-medium">EDIT</span>
                        </button>
                        <button
                            class="flex w-full justify-center items-center gap-2 rounded border border-blue-500 px-8 py-4 text-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring active:bg-blue-600"
                            onclick="window.location.href = './screen.php'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M4 3a1 1 0 00-1 1v10a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H4zm2 2h8a1 1 0 110 2H6a1 1 0 010-2zm0 4h8a1 1 0 110 2H6a1 1 0 110-2z" />
                            </svg>
                            <span class="text-sm font-medium">SCREENS</span>
                        </button>
                    </div>
                </div>
            </div>


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
                    <button onclick="applyAction(${id})" class="px-8 w-full py-3 bg-red-500 text-white rounded-lg hover:bg-red-600">Apply</button>
                    <button onclick="closeModal()" class="px-8 w-full py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Dismiss</button>
                </div>
            `;
                break;
            case "warn":
                titleTag = `<h2 class="text-xl font-bold w-full">${title}</h2>`;
                descriptionTag = `<p class="mt-4 text-gray-600 w-full">${description}</p>`;
                actionButtons = `
                <div class="flex w-full justify-end mt-6">
                    <button onclick="closeModal()" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Dismiss</button>
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
                </div>`;
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
        </div>`;

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

    function applyAction(cinema_id) {
        $.ajax({
            url: "./controllers/delete_cinema.php",
            type: "POST",
            data: {
                cinema_id: cinema_id
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    window.location.reload(); 
                } else {
                    if (response.errors) {
                        const errorMessages = response.errors.join("\n");
                        alert("Validation Errors:\n" + errorMessages);
                    } else {
                        alert("Error: " + response.message);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("An unexpected error occurred. Please try again.");
            },
        });
        closeModal();
    }



    $(document).ready(function() {
        $.ajax({
            url: './controllers/fetch_cinemas.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#cinemas-grid').empty();

                data.forEach(function(cinema) {
                    var cinemaHTML = `
                        <div class="cinema bg-[#021526] h-[500px] relative rounded-xl">
                            <div class="inner p-6 w-full h-full flex flex-col justify-between">
                                <div class="flex justify-center items-center w-full my-5">
                                    <h3 class="cinema-name text-lg font-medium text-white py-2">${cinema.cinema_name}</h3>
                                </div>
                                <span class="cinema-type font-semibold text-2xl text-center py-4 rounded-full">${cinema.cinema_type || 'N/A'}</span>
                                <div class="my-2 flex flex-col gap-3">
                                    <button onclick="openModal('Are you sure...', 'you want to delete this cinema &quot;${cinema.cinema_name}&quot;', 'danger', ${cinema.cinema_id})"
                                        class="flex w-full justify-center items-center gap-2 rounded border border-red-500 px-8 py-4 text-red-500 hover:bg-red-500 hover:text-white focus:outline-none focus:ring active:bg-red-600">
                                        <!-- Delete Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1zM5 4a1 1 0 00-1 1v11a2 2 0 002 2h6a2 2 0 002-2V5a1 1 0 00-1-1H5zm7 2a1 1 0 00-2 0v7a1 1 0 002 0V6zm-4 0a1 1 0 00-2 0v7a1 1 0 002 0V6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm font-medium">DELETE</span>
                                    </button>
                                    <button onclick="window.location.href = './edit_cinema.php?cinema_id=${cinema.cinema_id}'"
                                        class="flex w-full justify-center items-center gap-2 rounded border border-yellow-500 px-8 py-4 text-yellow-500 hover:bg-yellow-500 hover:text-white focus:outline-none focus:ring active:bg-yellow-600">
                                        <!-- Edit Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 010 2.828l-9.828 9.828a2 2 0 01-1.263.732l-4 1a1 1 0 01-1.212-1.212l1-4a2 2 0 01.732-1.263l9.828-9.828a2 2 0 012.828 0zm-5.828 3.414l-8.585 8.586-.293 1.171 1.171-.293 8.586-8.585-1.707-1.707zm2.121-2.121l-1.414 1.414 1.707 1.707 1.414-1.414-1.707-1.707z" />
                                        </svg>
                                        <span class="text-sm font-medium">EDIT</span>
                                    </button>
                                    <button class="flex w-full justify-center items-center gap-2 rounded border border-blue-500 px-8 py-4 text-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring active:bg-blue-600"
                                        onclick="window.location.href = './screen.php?cinema_id=${cinema.cinema_id}'">
                                        <!-- Screen Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M4 3a1 1 0 00-1 1v10a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H4zm2 2h8a1 1 0 110 2H6a1 1 0 010-2zm0 4h8a1 1 0 110 2H6a1 1 0 110-2z" />
                                        </svg>
                                        <span class="text-sm font-medium">SCREENS</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#cinemas-grid').append(cinemaHTML);
                });
            },
            error: function() {
                alert('Failed to fetch cinemas.');
            }
        });
    });
</script>
</body>

</html>