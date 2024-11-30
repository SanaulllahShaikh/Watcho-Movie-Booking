<?php
$active_tab = '';
include_once '../controllers/config.php';
include './includes/header.php';
$cinemaId = $_GET['cinema_id'];
$sql = "SELECT cinema_name, address, city, state, postal_code, contact_number, cinema_type FROM cinemas WHERE cinema_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $cinemaId);
$stmt->execute();
$result = $stmt->get_result();
$cinema = $result->fetch_assoc();

if (!$cinema) {
    echo "Cinema not found.";
    exit;
}
?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">EDIT CINEMA</h1>
            <a href="./cinemas.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Cinemas
            </a>
        </div>

        <div
            class="border border-gray-800 p-8 rounded-xl mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

            <div class="inputs col-span-2">
                <form id="editCinemaForm" method="POST">
                    <div class="space-y-6">
                        <!-- Hidden ID Field -->
                        <input type="hidden" id="cinemaId" name="cinemaId" value="<?= htmlspecialchars($cinemaId) ?>">

                        <!-- Cinema Name -->
                        <input type="text" id="cinemaName" name="cinemaName" placeholder="Cinema Name"
                            value="<?= htmlspecialchars($cinema['cinema_name']) ?>"
                            class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">

                        <!-- Address -->
                        <textarea id="cinemaAddress" name="cinemaAddress" placeholder="Address" rows="3"
                            class="w-full py-3 px-5 rounded-lg border border-gray-300 border-gray-600 bg-[#222831] resize-none"><?= htmlspecialchars($cinema['address']) ?></textarea>

                        <!-- City, State, Postal Code -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" id="cinemaCity" name="cinemaCity" placeholder="City"
                                value="<?= htmlspecialchars($cinema['city']) ?>"
                                class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                            <input type="text" id="cinemaState" name="cinemaState" placeholder="State"
                                value="<?= htmlspecialchars($cinema['state']) ?>"
                                class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                            <input type="text" id="cinemaPostalCode" name="cinemaPostalCode" placeholder="Postal Code"
                                value="<?= htmlspecialchars($cinema['postal_code']) ?>"
                                class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                        </div>

                        <!-- Cinema Type Dropdown -->
                        <div class="mt-4">
                            <label for="cinema_type" class="block text-gray-700 ml-4 mb-2 text-gray-300">Cinema Type</label>
                            <select id="cinema_type" name="cinema_type" class="w-full py-3 px-4 rounded-full border border-gray-300 border-gray-600 bg-[#222831] transition-all duration-200">
                                <option value="Standard" <?= ($cinema['cinema_type'] == 'Standard') ? 'selected' : '' ?>>Standard</option>
                                <option value="IMAX" <?= ($cinema['cinema_type'] == 'IMAX') ? 'selected' : '' ?>>IMAX</option>
                                <option value="3D" <?= ($cinema['cinema_type'] == '3D') ? 'selected' : '' ?>>3D</option>
                            </select>
                        </div>

                        <!-- Contact Number -->
                        <input type="text" id="cinemaContact" name="cinemaContact" placeholder="Contact Number"
                            value="<?= htmlspecialchars($cinema['contact_number']) ?>"
                            class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="bg-[#1D267D] text-[#DDE6ED] py-2 px-5 rounded-full transition duration-300 hover:bg-[#2F58CD]">
                            SAVE CHANGES
                        </button>
                    </div>
                </form>
            </div>


        </div>
    </main>



</div>
</div>
<script>
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


    $(document).ready(function() {
        $("#editCinemaForm").submit(function(e) {
            e.preventDefault();

            const cinemaData = {
                cinemaId: $("#cinemaId").val(),
                name: $("#cinemaName").val(),
                address: $("#cinemaAddress").val(),
                city: $("#cinemaCity").val(),
                state: $("#cinemaState").val(),
                postalCode: $("#cinemaPostalCode").val(),
                contact: $("#cinemaContact").val(),
                cinemaType: $("#cinema_type").val()
            };

            $.ajax({
                url: "./controllers/update_cinema.php",
                type: "POST",
                data: cinemaData,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        openModal('This cinema updated successfully: '+response.cinema_name, 'You updated '+response.cinema_name+' successfully');
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
        });
    });
</script>

</body>

</html>