<?php
$active_tab = 'shows';
include './includes/header.php';

?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">ALL SHOWS</h1>
            <a href="./upload_show.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                New show
            </a>

        </div>
        <div class="mt-2 relative">
            <input type="text" id="searchShow" placeholder="Search show by movie name or theatre"
                class="w-full py-3 pr-16 pl-6 rounded-full border border-gray-700 bg-[#222831] text-white placeholder-gray-400 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#CC2B52]">
            <button
                class="absolute right-0 top-1/2 transform -translate-y-1/2 text-[#CC2B52] h-full pl-4 pr-6 rounded-r-full transition duration-300  hover:bg-[#CC2B52]  hover:text-white ">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 " viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
                </svg>
            </button>
        </div>
        <div id="shows-grid" class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-white">

            <div class="cinema bg-[#021526] h-[500px] relative rounded-xl">
                <div class="inner p-6 w-full h-full flex flex-col justify-between">
                    <div class="flex justify-center flex-col items-center w-full my-5">
                        <h3 class="cinema-name text-md font-medium text-white pt-2 theatre-name">ISLAMABAD Cinema</h3>
                        <h3 class="cinema-name text-xl font-medium text-white pb-2">Cinema screen 1</h3>
                    </div>
                    <div class="cinema-type rounded-full py-4 w-full flex flex-col items-center justify-center">
                        <h5 class="font-semibold text-lg pb-2 show-name">MOVIE NAME</h5>
                        <h5 class="font-semibold text-2xl pb-2">JOHN WICK CHAPTER 4</h5>
                        <div class="px-8 flex justify-between w-full">
                            <span class="text-sm flex flex-col">
                                <span>SHOW START</span>
                                <span>2:00 am</span>
                            </span>
                            <span class="text-sm flex flex-col">
                                <span>SHOW END</span>
                                <span>4:00 am</span>
                            </span>
                        </div>
                    </div>
                    <div class="my-2 flex flex-col gap-1">
                        <button
                            class="flex w-full justify-center items-center gap-2 rounded border border-blue-500 px-8 py-4 text-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring active:bg-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M4 3a1 1 0 00-1 1v10a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H4zm2 2h8a1 1 0 110 2H6a1 1 0 010-2zm0 4h8a1 1 0 110 2H6a1 1 0 110-2z" />
                            </svg>
                            <span class="text-sm font-medium">INFO</span>
                        </button>
                        <button
                            class="flex w-full justify-center items-center gap-2 rounded border border-yellow-500 px-8 py-4 text-yellow-500 hover:bg-yellow-500 hover:text-white focus:outline-none focus:ring active:bg-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M17.414 2.586a2 2 0 010 2.828l-9.828 9.828a2 2 0 01-1.263.732l-4 1a1 1 0 01-1.212-1.212l1-4a2 2 0 01.732-1.263l9.828-9.828a2 2 0 012.828 0zm-5.828 3.414l-8.585 8.586-.293 1.171 1.171-.293 8.586-8.585-1.707-1.707zm2.121-2.121l-1.414 1.414 1.707 1.707 1.414-1.414-1.707-1.707z" />
                            </svg>
                            <span class="text-sm font-medium">EDIT</span>
                        </button>
                        <button
                            class="flex w-full justify-center items-center gap-2 rounded border border-red-500 px-8 py-4 text-red-500 hover:bg-red-500 hover:text-white focus:outline-none focus:ring active:bg-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1zM5 4a1 1 0 00-1 1v11a2 2 0 002 2h6a2 2 0 002-2V5a1 1 0 00-1-1H5zm7 2a1 1 0 00-2 0v7a1 1 0 002 0V6zm-4 0a1 1 0 00-2 0v7a1 1 0 002 0V6z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium">DELETE</span>
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
                    <button onclick="applyAction(${id})" class="px-8 w-full py-3 bg-red-500 text-white rounded-lg hover:bg-red-600">Yes</button>
                    <button onclick="closeModal()" class="px-8 w-full py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">No</button>
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


    function applyAction(show_id) {
        $.ajax({
            url: './controllers/delete_show.php',
            type: 'POST',
            data: {
                show_id: show_id
            },
            success: function(response) {
                try {
                    const result = JSON.parse(response);
                    if (result.success) {
                        window.location.reload();
                    } else {
                        openModal('Deletion Error', result.message || 'An error occurred while deleting the show.', 'danger');
                    }
                } catch (e) {
                    console.error('Error parsing response:', e, response);
                    openModal('System Error', 'An unexpected error occurred. Please try again.', 'systemError');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                openModal('Server Error', 'Unable to connect to the server. Please try again later.', 'serverError');
            }
        });
    }


    function fetchShows() {
        $.ajax({
            url: './controllers/fetch_shows.php',
            type: 'GET',
            success: function(response) {
                if (!response.error) {
                    const showsGrid = $('#shows-grid');
                    showsGrid.empty();

                    function formatTime(timeString) {
                        const [hours, minutes] = timeString.split(':').map(Number);

                        const period = hours >= 12 ? 'PM' : 'AM';

                        const formattedHours = hours % 12 || 12;

                        return `${formattedHours}:${minutes.toString().padStart(2, '0')} ${period}`;
                    }

                    function formatDate(dateString) {
                        const date = new Date(dateString);

                        const options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        return new Intl.DateTimeFormat('en-US', options).format(date);
                    }



                    response.shows.forEach(show => {

                        const formatedShow_start = formatTime(show.show_start);
                        const formatedShow_end = formatTime(show.show_end);
                        const formatedShow_date = formatDate(show.show_date);
                        console.log(formatedShow_start, formatedShow_end, formatedShow_date);
                        const showHtml = `
                                <div class="cinema bg-[#021526] h-[500px] relative rounded-xl">
                                    <div class="inner p-6 w-full h-full flex flex-col justify-between">
                                        <div class="flex justify-center flex-col items-center w-full my-5">
                                            <h3 class="cinema-name text-md font-medium text-white pt-2 theatre-name">${show.cinema_name}</h3>
                                            <h3 class="text-xl font-medium text-white pb-2">$${show.seat_price}</h3>
                                        </div>
                                        <div class="cinema-type rounded-full py-4 w-full flex flex-col items-center justify-center">
                                            <h5 class="font-semibold text-lg pb-2">MOVIE NAME</h5>
                                            <h5 class="font-semibold text-2xl pb-2 movie-name">${show.movie_name}</h5>
                                            <div class="flex flex-col items-center w-full">
                                            <div class="px-8 flex justify-between w-full">
                                                <span class="text-sm flex flex-col">
                                                    <span>SHOW START</span>
                                                    <span>${formatedShow_start}</span>
                                                </span>
                                                <span class="text-sm flex flex-col">
                                                    <span>SHOW END</span>
                                                    <span>${formatedShow_end}</span>
                                                </span>
                                            </div>
                                                <span class="text-sm flex text-center flex-col">
                                                    <span>SHOW DATE</span>
                                                    <span>${formatedShow_date}</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="my-2 flex flex-col gap-1">
                                            <button onclick="openModal('Information about show', 'show id:&quot;${show.show_id}&quot;<br />cinema name:&quot;${show.cinema_name}&quot;<br />screen name:&quot;${show.screen_name}&quot;<br />movie name:&quot;${show.movie_name}&quot;<br />Show Date:&quot;${formatedShow_date}&quot;<br />Show Start:&quot;${formatedShow_start}&quot;<br />Show End:&quot;${formatedShow_end}&quot;', 'showInfo');" class="flex w-full justify-center items-center gap-2 rounded border border-blue-500 px-8 py-4 text-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring active:bg-blue-600">
                                                <span class="text-sm font-medium">INFO</span>
                                            </button>
                                            <button  onclick="window.location.href='./edit_show.php?show_id=${show.show_id}'" class="flex w-full justify-center items-center gap-2 rounded border border-yellow-500 px-8 py-4 text-yellow-500 hover:bg-yellow-500 hover:text-white focus:outline-none focus:ring active:bg-yellow-600">
                                                <span class="text-sm font-medium">EDIT</span>
                                            </button>
                                            <button onclick="openModal('Are you sure!', 'you want to delete show?<br />cinema name:&quot;${show.cinema_name}&quot;<br />screen name:&quot;${show.screen_name}&quot;<br />movie name:&quot;${show.movie_name}&quot;', 'danger', ${show.show_id});" class="flex w-full justify-center items-center gap-2 rounded border border-red-500 px-8 py-4 text-red-500 hover:bg-red-500 hover:text-white focus:outline-none focus:ring active:bg-red-600">
                                                <span class="text-sm font-medium">DELETE</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;

                        showsGrid.append(showHtml);
                        document.getElementById("searchShow").addEventListener("input", function() {
                            const searchValue = this.value.toLowerCase();
                            const rows = document.querySelectorAll("#shows-grid .cinema");

                            rows.forEach((row) => {
                                const nameElement = row.querySelector('.cinema-name');
                                const movieElement = row.querySelector('.movie-name');
                                const theaname = nameElement ? nameElement.textContent.toLowerCase() : '';
                                const movname = movieElement ? movieElement.textContent.toLowerCase() : '';

                                if (theaname.includes(searchValue) || movname.includes(searchValue)) {
                                    row.style.display = ""; // Show the row
                                } else {
                                    row.style.display = "none"; // Hide the row
                                }
                            });
                        });

                    });
                } else {
                    console.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching shows:", error);
                openModal('Error fetching shows', 'Error occured while fetching shows.');

            }
        });
    }

    fetchShows();
</script>

</body>

</html>