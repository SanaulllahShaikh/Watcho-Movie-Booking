<?php
$active_tab = '';
include './includes/header.php';
require_once '../controllers/config.php';

$cinema_id = $_GET['cinema_id'];
$screen_id = $_GET['screen_id'];

$query = "SELECT s.screen_name, s.screen_type, s.total_seats, c.cinema_name 
          FROM screens s
          INNER JOIN cinemas c ON s.cinema_id = c.cinema_id
          WHERE s.screen_id = ? AND s.cinema_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $screen_id, $cinema_id);
$stmt->execute();
$stmt->bind_result($screen_name, $screen_type, $total_seats, $cinema_name);
$stmt->fetch();
$stmt->close();
?>
?>

<div class="flex-grow px-6">
    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">EDIT SCREEN</h1>
            <a href="./screens.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Screens
            </a>
        </div>

        <div class="border border-gray-800 p-8 rounded-xl mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            <form id="edit-screen-form" class="inputs col-span-2" method="POST">
                <div class="space-y-6">
                    <input type="text" id="screen_name" name="screen_name"
                        value="<?= htmlspecialchars($screen_name) ?>"
                        placeholder="Screen Name"
                        class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]" required>

                    <div class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]">
                        <label for="cinema_id">Cinema = <?= htmlspecialchars($cinema_name) ?></label>
                    </div>
                    <input type="hidden" id="cinema_id" name="cinema_id" value="<?= $cinema_id ?>">
                    <input type="hidden" id="screen_id" name="screen_id" value="<?= $screen_id ?>">

                    <input type="number" id="total_seats" name="total_seats"
                        value="<?= $total_seats ?>"
                        placeholder="Seat Capacity"
                        class="w-full py-3 px-5 rounded-full border border-gray-300 border-gray-600 bg-[#222831]" required>

                    <select id="screen_type" name="screen_type"
                        class="w-full py-3 px-4 rounded-full border border-gray-300 border-gray-600 bg-[#222831] transition-all duration-200" required>
                        <option value="" disabled>Select Screen Type</option>
                        <option value="Standard" <?= $screen_type === 'Standard' ? 'selected' : '' ?>>Standard</option>
                        <option value="IMAX" <?= $screen_type === 'IMAX' ? 'selected' : '' ?>>IMAX</option>
                        <option value="3D" <?= $screen_type === '3D' ? 'selected' : '' ?>>3D</option>
                    </select>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="bg-[#1D267D] text-[#DDE6ED] py-2 px-5 rounded-full transition duration-300 hover:bg-[#2F58CD]">
                        SAVE CHANGES
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
</div>
<script>
    const selectElement = document.getElementById('screen_type');

    selectElement.addEventListener('focus', () => {
        selectElement.classList.remove('rounded-full');
        selectElement.classList.add('rounded-t-full', 'rounded-b-0');
    });

    selectElement.addEventListener('blur', () => {
        selectElement.classList.remove('rounded-t-full', 'rounded-b-0');
        selectElement.classList.add('rounded-full');
    });


    function openModal(title, description, type = "default", id = 0) {
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
                    <button onclick="applyAction()" class="px-6 py-2 w-full bg-blue-200 text-gray-950 rounded-lg hover:bg-gray-300">CLOSE</button>
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
    }


    function applyAction(cinema_id) {
        window.location.href = "./screen.php?cinema_id=<?= $cinema_id ?>"
    }

    $(document).ready(function() {
        $('#edit-screen-form').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: './controllers/update_screen.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    const res = JSON.parse(response);
                    openModal("Screen updated successfully", "you updated a screen successfully ", "info");
                },
                error: function() {
                    alert('Failed to update screen. Please try again.');
                }
            });
        });
    });
</script>
</body>

</html>