<?php
$active_tab = '';
include './includes/header.php';
include '../controllers/config.php';

$show_id = $_GET['show_id'];
$showQuery = "SELECT * FROM shows WHERE show_id = ?";
$stmt = $conn->prepare($showQuery);
$stmt->bind_param("i", $show_id);
$stmt->execute();
$showResult = $stmt->get_result();
$showData = $showResult->fetch_assoc();

$movie_id = $showData['movie_id'];
$screen_id = $showData['screen_id'];
$seat_price = $showData['price'];
$show_date = $showData['show_date'];
$show_time = $showData['show_time'];
$show_end = $showData['show_end'];

$cinemaQuery = "SELECT cinema_id FROM screens WHERE screen_id = ?";
$cinemaStmt = $conn->prepare($cinemaQuery);
$cinemaStmt->bind_param("i", $screen_id);
$cinemaStmt->execute();
$cinemaResult = $cinemaStmt->get_result();
$cinemaData = $cinemaResult->fetch_assoc();
$cinema_id = $cinemaData['cinema_id'];
?>

<div class="flex-grow px-6">

    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">UPLOAD SHOW</h1>
            <a href="./show.php"
                class="bg-[#222831] py-2 px-4 rounded-md text-[#CC2B52] transition duration-300 hover:bg-[#CC2B52] hover:text-[#e0e0e0]">
                Shows
            </a>
        </div>

        <div class="border border-gray-800 p-8 rounded-xl mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            <form id="update-show-form" class="inputs col-span-2" method="POST">
                <div class="space-y-6">
                    <select id="cinema_id" name="cinema_id" class="w-full py-3 px-4 rounded-full border border-gray-300 border-gray-600 bg-[#222831]" required>
                        <option value="" disabled>Select Cinema</option>
                        <?php
                        $cinemasQuery = "SELECT cinema_id, cinema_name FROM cinemas";
                        $cinemasResult = $conn->query($cinemasQuery);
                        while ($cinema = $cinemasResult->fetch_assoc()) {
                            $selected = ($cinema['cinema_id'] == $cinema_id) ? 'selected' : '';
                            echo "<option value='{$cinema['cinema_id']}' {$selected}>{$cinema['cinema_name']}</option>";
                        }
                        ?>
                    </select>

                    <select id="screen_id" name="screen_id" class="w-full py-3 px-4 rounded-full border border-gray-300 border-gray-600 bg-[#222831]" required>
                        <option value="" disabled>Select Screen</option>
                        <?php
                        $screensQuery = "SELECT screen_id, screen_name FROM screens WHERE cinema_id = ?";
                        $screensStmt = $conn->prepare($screensQuery);
                        $screensStmt->bind_param('i', $cinema_id);
                        $screensStmt->execute();
                        $screensResult = $screensStmt->get_result();
                        while ($screen = $screensResult->fetch_assoc()) {
                            $selected = ($screen['screen_id'] == $screen_id) ? 'selected' : '';
                            echo "<option value='{$screen['screen_id']}' {$selected}>{$screen['screen_name']}</option>";
                        }
                        ?>
                    </select>

                    <select id="movie_id" name="movie_id" class="w-full py-3 px-4 rounded-full border border-gray-300 border-gray-600 bg-[#222831]" required>
                        <option value="" disabled>Select Movie</option>
                        <?php
                        $moviesQuery = "SELECT movie_id, title FROM movies WHERE is_published = 1";
                        $moviesResult = $conn->query($moviesQuery);
                        while ($movie = $moviesResult->fetch_assoc()) {
                            $selected = ($movie['movie_id'] == $movie_id) ? 'selected' : '';
                            echo "<option value='{$movie['movie_id']}' {$selected}>{$movie['title']}</option>";
                        }
                        ?>
                    </select>

                    <input type="hidden" id="show_id" name="show_id" class="hidden" value="<?php echo $show_id; ?>">

                    <input type="number" id="seat_price" name="seat_price" value="<?= $seat_price?>" placeholder="Price per seat $"
                        class="w-full py-3 px-4 rounded-full border border-gray-300 border-gray-600 bg-[#222831]" required>

                    <input type="date" id="show_date" name="show_date" class="w-full py-3 px-4 rounded-full border border-gray-300 border-gray-600 bg-[#222831]" value="<?php echo $show_date; ?>" required>
                    <input type="time" id="show_time" name="show_time" class="w-full py-3 px-4 rounded-full border border-gray-300 border-gray-600 bg-[#222831]" value="<?php echo $show_time; ?>" required>
                    <input type="time" id="show_end" name="show_end" class="w-full py-3 px-4 rounded-full border border-gray-300 border-gray-600 bg-[#222831]" value="<?php echo $show_end; ?>" required>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" id="submit-show-btn" class="bg-[#1D267D] text-[#DDE6ED] py-2 px-5 rounded-full transition duration-300 hover:bg-[#2F58CD]">
                        UPDATE SHOW
                    </button>
                </div>
            </form>


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
            case "success":
                titleTag = `<h2 class="text-xl font-bold w-full">${title}</h2>`;
                descriptionTag = `<p class="mt-4 text-gray-600 w-full py-2">${description}</p>`;
                actionButtons = `
                <div class="flex justify-center w-full mt-6">
                    <button onclick="redirectToShows()" class="px-6 py-2 w-full bg-blue-200 text-gray-950 rounded-lg hover:bg-gray-300">CLOSE</button>
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
        console.log('Action applied');

        closeModal();
    }

    function redirectToShows() {
        window.location.href = './show.php';
        closeModal();
    }

    $(document).ready(function() {
        $('#cinema_id').on('change', function() {
            const cinemaId = $(this).val();
            const screenDropdown = $('#screen_id');

            screenDropdown.html('<option value="" disabled selected>Select Screen</option>');

            if (cinemaId) {
                $.ajax({
                    url: './controllers/show_fetch_screens.php',
                    type: 'GET',
                    data: {
                        cinema_id: cinemaId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.screens) {
                            response.screens.forEach(screen => {
                                screenDropdown.append(
                                    `<option value="${screen.screen_id}">${screen.screen_name}</option>`
                                );
                            });
                        } else {
                            openModal('Error', 'No screens found for the selected cinema.', 'uploadError');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching screens:', error);
                        openModal('An error', 'An error occurred while fetching screens.', 'success');
                    }
                });
            }
        });

        $('#update-show-form').on('submit', function(e) {
            e.preventDefault();

            const formData = {
                show_id: $('#show_id').val(),
                cinema_id: $('#cinema_id').val(),
                screen_id: $('#screen_id').val(),
                movie_id: $('#movie_id').val(),
                seat_price: $('#seat_price').val(),
                show_date: $('#show_date').val(),
                show_time: $('#show_time').val(),
                show_end: $('#show_end').val()
            };
            console.log(formData);


            if (!formData.show_id || !formData.cinema_id || !formData.screen_id || !formData.movie_id || !formData.show_date || !formData.show_time || !formData.show_end) {
                openModal('Validation Error', 'Please fill all fields.', 'validationErr');
                return;
            }

            $.ajax({
                url: './controllers/update_show.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    try {
                        console.log(response);

                        const result = JSON.parse(response);
                        if (result.success) {
                            openModal('Show updated successfully!', 'The show details have been updated.', 'success');
                            $('#update-show-form')[0].reset();
                        } else {
                            openModal('Update Error', 'An error occurred while updating the show.', 'updateError');
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e, response);
                        openModal('System Error', 'An unexpected error occurred. Please try again.', 'systemError');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error updating show:', error);
                    openModal('Server Error', 'An error occurred while connecting to the server.', 'serverError');
                }
            });
        });



    });
</script>
</body>

</html>