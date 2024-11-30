<?php
$active_tab = '';
include './includes/header.php';

?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">UPLOAD CINEMA</h1>
            <a href="./cinemas.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Cinemas
            </a>
        </div>
        <div class="border border-gray-800 p-8 rounded-xl mt-4 grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">

            <!-- Cinema Details Form -->
            <form id="uploadCinemaForm" method="POST">
                <div class="inputs col-span-2">
                    <div class="space-y-6">
                        <!-- Cinema Name -->
                        <input type="text" id="cinema_name" name="cinema_name" placeholder="Cinema Name"
                            class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">

                        <!-- Address -->
                        <textarea id="cinema_address" name="cinema_address" placeholder="Address" rows="4"
                            class="w-full py-3 px-5 rounded-lg border border-gray-300 border-gray-600 bg-[#222831] resize-none"></textarea>

                        <!-- City, State, and Postal Code -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" id="cinema_city" name="cinema_city" placeholder="City"
                                class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                            <input type="text" id="cinema_state" name="cinema_state" placeholder="State"
                                class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                            <input type="text" id="cinema_postal_code" name="cinema_postal_code" placeholder="Postal Code"
                                class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                        </div>

                        <!-- Contact Number -->
                        <input type="text" id="cinema_contact_number" name="cinema_contact_number" placeholder="Contact Number"
                            class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">

                        <!-- Cinema Type Dropdown -->
                        <select id="cinema_type" name="cinema_type" class="w-full py-3 px-4 rounded-full border border-gray-300 border-gray-600 bg-[#222831] transition-all duration-200">
                            <option value="Standard">Standard</option>
                            <option value="IMAX">IMAX</option>
                            <option value="3D">3D</option>
                        </select>

                    </div>

                    <!-- Upload Button -->
                    <div class="flex justify-end mt-4">
                        <button type="submit" id="uploadCinemaBtn"
                            class="bg-[#1D267D] text-[#DDE6ED] py-2 px-5 rounded-full transition duration-300 hover:bg-[#2F58CD]">
                            UPLOAD
                        </button>
                    </div>
                </div>
            </form>

        </div>


    </main>

</div>
</div>
<script>
    const selectElement = document.getElementById('cinema_type');

    selectElement.addEventListener('focus', () => {
        selectElement.classList.remove('rounded-full');
        selectElement.classList.add('rounded-t-full', 'rounded-b-0');
    });

    selectElement.addEventListener('blur', () => {
        selectElement.classList.remove('rounded-t-full', 'rounded-b-0');
        selectElement.classList.add('rounded-full');
    });


    function openModal(title, description, type = "default") {
        const modal = document.createElement('div');
        let titleTag = "";
        let descriptionTag = "";
        let actionButtons = "";

        switch (type) {
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
                    <button onclick="applyAction()" class="px-6 py-2 w-full bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">OK</button>
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
    }


    function applyAction() {
        window.location.href = './cinemas.php';
        closeModal();
    }


    $('#uploadCinemaForm').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: './controllers/upload_cinema.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response === 'success') {
                    openModal('Cinema uploaded successfully', 'You upload a new cinema');

                } else {
                    alert('Failed to upload cinema details. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>
</body>

</html>