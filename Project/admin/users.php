<?php
$active_tab = 'users';
include './includes/header.php';

?>


<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">ALL USERS <span class="text-sm text-[#CC2B52]">TOTAL: <span id="count-users">0000</span></span></h1>
            <div class="relative">
                <input type="text" id="searchUser" placeholder="Search user by name or email"
                    class="w-80 py-2 pr-16 pl-6 rounded-full border border-gray-700 bg-[#222831] text-white placeholder-gray-400 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#CC2B52]">
                <button
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 text-[#CC2B52] h-full pl-4 pr-6 rounded-r-full transition duration-300  hover:bg-[#CC2B52]  hover:text-white ">
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
                        <th class="py-3 px-4 text-center text-xs font-normal">ID</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">USERNAME</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">EMAIL</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">REVIEWS</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">AGE</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">JOINED</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">STATUS</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="usersBody">
                    <tr class="bg-[#021526]">
                        <td class="py-5 px-4 text-center text-md">1</td>
                        <td class="py-5 px-4 text-center text-md">john_doe</td>
                        <td class="py-5 px-4 text-center text-md">john.doe@example.com</td>
                        <td class="py-5 px-4 text-center text-md">25</td>
                        <td class="py-5 px-4 text-center text-md">28</td>
                        <td class="py-5 px-4 text-center text-md">2024-01-15</td>
                        <td class="py-5 px-4 text-center text-md">Active</td>
                        <td class="py-5 px-4 space-x-2 flex items-center justify-center">
                            <button
                                class="bg-[#1E5128] text-[#03C988] p-1 rounded-md transition duration-300 hover:bg-[#3B5249]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M19 10H20C20.5523 10 21 10.4477 21 11V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11C3 10.4477 3.44772 10 4 10H5V9C5 5.13401 8.13401 2 12 2C15.866 2 19 5.13401 19 9V10ZM5 12V20H19V12H5ZM11 14H13V18H11V14ZM17 10V9C17 6.23858 14.7614 4 12 4C9.23858 4 7 6.23858 7 9V10H17Z">
                                    </path>
                                </svg>
                            </button>
                            <!-- <button
                                class="bg-[#00337C] text-[#1C82AD] p-1 rounded-md transition duration-300 hover:bg-[#13005A] hover:text-[#1C82AD]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M15.7279 9.57627L14.3137 8.16206L5 17.4758V18.89H6.41421L15.7279 9.57627ZM17.1421 8.16206L18.5563 6.74785L17.1421 5.33363L15.7279 6.74785L17.1421 8.16206ZM7.24264 20.89H3V16.6473L16.435 3.21231C16.8256 2.82179 17.4587 2.82179 17.8492 3.21231L20.6777 6.04074C21.0682 6.43126 21.0682 7.06443 20.6777 7.45495L7.24264 20.89Z">
                                    </path>
                                </svg>
                            </button> -->
                            <button
                                class="bg-[#821131] text-[#CC2B52] p-1 rounded-md transition duration-300 hover:bg-[#800000]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z">
                                    </path>
                                </svg>
                            </button>
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="currentColor"><path d="M15.7279 9.57627L14.3137 8.16206L5 17.4758V18.89H6.41421L15.7279 9.57627ZM17.1421 8.16206L18.5563 6.74785L17.1421 5.33363L15.7279 6.74785L17.1421 8.16206ZM7.24264 20.89H3V16.6473L16.435 3.21231C16.8256 2.82179 17.4587 2.82179 17.8492 3.21231L20.6777 6.04074C21.0682 6.43126 21.0682 7.06443 20.6777 7.45495L7.24264 20.89Z"></path></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z"></path></svg> -->
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
                    <button onclick="closeModal('reload')" class="px-6 py-2 w-full bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">OK</button>
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

    function applyAction(user_id) {
        console.log("Action applied!");
        $.ajax({
            url: './controllers/delete_user.php',
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: user_id
            },
            success: function(response) {
                if (response['success']) {
                    openModal(response['message'], 'You deleted user successfully...');
                } else {
                    alert('Failed to delete user', response);
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error("Error deleting user: ", status, error);
                alert('An error occurred. Please try again.');
            }
        });

        closeModal();
    }

    $.ajax({
        url: './controllers/fetch_users.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const usersBody = $('#usersBody');
            usersBody.empty();
            document.getElementById('count-users').innerHTML=data.length
            data.forEach(user => {
                const row = `
                <tr class="bg-[#021526]" data-username='${user.username}' data-email='${user.email}'>
                    <td class="py-5 px-4 text-center text-md">${user.id}</td>
                    <td class="py-5 px-4 text-center text-md">${user.username}</td>
                    <td class="py-5 px-4 text-center text-md">${user.email}</td>
                    <td class="py-5 px-4 text-center text-md">${user.reviews}</td>
                    <td class="py-5 px-4 text-center text-md">${user.age}</td>
                    <td class="py-5 px-4 text-center text-md">${user.joined}</td>
                    <td class="py-5 px-4 text-center text-md">${user.status}</td>
                    <td class="py-5 px-4 space-x-2 flex items-center justify-center">
                        <button onclick="openModal('Information about ${user.id}', '[${user.username}, ${user.email}, ${user.reviews}, ${user.age}, ${user.joined}, ${user.status}]', 'info')" class="bg-[#1E5128] text-[#03C988] p-1 rounded-md transition duration-300 hover:bg-[#3B5249]">Info</button>
                        
                        <button onclick="openModal('Are you sure...', 'you want to delete this user &quot;${user.username}&quot;?', 'danger', '${user.id}')" class="bg-[#821131] text-red-400 p-1 rounded-md transition duration-300 hover:bg-[#800000]">Delete</button>
                    </td>
                </tr>
            `;
                usersBody.append(row);
            });
            document.getElementById("searchUser").addEventListener("input", function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll("#usersBody tr");

                rows.forEach((row) => {
                    const name = row.getAttribute("data-username").toLowerCase();
                    const email = row.getAttribute("data-email").toLowerCase();
                    if (name.includes(searchValue) || email.includes(searchValue)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
    },
    error: function(xhr, status, error) {
        console.error('Error fetching users:', error);
    }
    });
</script>
</body>

</html>