<?php
$page = "seat_book";
include('../includes/header.php');
require_once '../controllers/config.php';

$movie_id = $_GET['movie_id'];

$query = "
    SELECT DISTINCT c.cinema_id, c.cinema_name, c.city, s.screen_id, s.screen_name 
    FROM cinemas c
    JOIN screens s ON c.cinema_id = s.cinema_id
    JOIN shows sh ON s.screen_id = sh.screen_id
    WHERE sh.movie_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$cinemas = [];
while ($row = $result->fetch_assoc()) {
    $cinemas[] = $row;
}

$query = "
    SELECT * FROM movies WHERE movie_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $movieDetails = $result->fetch_assoc();
    $title = $movieDetails['title'];
    $poster_url = $movieDetails['poster_url'];
    $banner_url = $movieDetails['banner_url'];
    if (strpos($banner_url, 'http') === 0) {
        $banner_url = $banner_url;
    } else {
        $banner_url = '.' . $banner_url;
    }
} else {
    echo "No movie found";
    exit;
}

$stmt->close();
$conn->close();
?>
<style>
    .vip-seat {
        background-color: gold;
        color: black;
        border: 1px solid #ccac00;
    }

    .seat.selected.vip-seat {
        background: red;
    }
</style>


<div class="primary-container min-h-screen flex flex-col gap-6 mx-auto w-full  p-6 px-0 pt-0 bg-gray-800">
    <div class="relative flex w-full items-center justify-center">
        <img src="<?= $banner_url ?>" class="object-fit w-full h-[300px]" alt="banner">
        <div class="absolute z-10 w-full h-full flex items-start justify-start pt-[200px] pl-[420px]" style="background: rgb(0, 0, 0, 0.5);">
            <h1 class="text-4xl text-white"><?= $title ?></h1>
        </div>
    </div>
    <div class="grid grid-cols-1 relative -top-[150px] sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-4 gap-4 w-full p-4">
        <div class="flex flex-col sticky z-50 col-span-2 lg:col-span-1">
            <img src=".<?= $poster_url ?>" class="w-full h-[550px] object-fit " alt="Poster">
            <div class="flex flex-col hidden" id="seats-details">
                <h4 class="text-center w-full py-4 text-white">Select seats</h4>

                <div class="booking-seats-container flex flex-col gap-2 py-4" id="booked-seats">
                </div>

                <div class="total-seat-price py-4 text-white">
                    <h2 class="text-lg px-4 flex justify-between my-2" id="seats-price"></h2>
                </div>


                <div class="total-seat-price flex py-4 text-white gap-4 mt-5">
                    <button onclick="cancelMovie();" class="border-red-600 border-2 rounded-md text-red-500 transition duration-300 hover:bg-red-600 hover:text-white w-full max-w-[120px] px-4 py-2">
                        CANCEL
                    </button>

                    <button onclick="bookMovie();" class="border-red-600 border-2 rounded-md bg-red-600 transition duration-300 hover:bg-transparent hover:text-red-600 w-full px-4 py-2">
                        NEXT
                    </button>
                </div>
            </div>
        </div>
        <div class="flex flex-col col-span-3 mt-[150px]">
            <div class="flex justify-center w-full py-2 px-4">
                <div class="sm:hidden">
                    <label for="Tab" class="sr-only">Tab</label>
                    <select
                        id="Tab"
                        class="w-full rounded-md border-gray-200 border-gray-700 bg-gray-900 text-white">
                        <option select>Settings</option>
                        <option>Messages</option>
                        <option>Archive</option>
                        <option>Notifications</option>
                    </select>
                </div>

                <div class="hidden sm:block">
                    <div class="border-b-4 border-gray-200 border-gray-700">
                        <nav class="-mb-[4px] flex w-full gap-14">
                            <button
                                class="shrink-0 text-upper border-b-4 border-red-600 p-3 w-[200px] flex-col lg:w-[200px] xl:w-[260px] text-md font-medium text-sky-600 border-gray-600 border-b-red-600 text-gray-300">
                                <span class="py-1 px-3 bg-gray-600 rounded-md text-zinc-300 mr-2">1</span>
                                CHOOSE YOU'RE PLACE
                            </button>

                            <button
                                class="shrink-0 border border-transparent p-3 w-[200px] flex-col lg:w-[200px] xl:w-[260px] text-md font-medium text-gray-500 hover:text-gray-700 text-gray-400  hover:text-gray-200">
                                <span class="py-1 px-3 bg-gray-600 rounded-md text-zinc-300 mr-2">2</span>
                                PAYMENT
                            </button>

                            <button
                                class="shrink-0 border border-transparent p-3 w-[200px] flex-col lg:w-[200px] xl:w-[260px] text-md font-medium text-gray-500 hover:text-gray-700 text-gray-400 hover:text-gray-200">
                                <span class="py-1 px-3 bg-gray-600 rounded-md text-zinc-300 mr-2">3</span>
                                TICKET
                            </button>

                        </nav>
                    </div>
                </div>
            </div>
            <div class="w-full text-white p-4 py-2">
                <label for="cinemaDropdown" class="block text-sm font-medium"> Cinema </label>

                <select
                    name="cinemaDropdown"
                    id="cinemaDropdown"
                    class="mt-1.5 py-3 px-2 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
                    <option value="" disabled selected>Select a Cinema</option>
                    <?php foreach ($cinemas as $cinema): ?>
                        <option value="<?= $cinema['cinema_id']; ?>"><?= $cinema['cinema_name']; ?> - <?= $cinema['city']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w-full text-white p-4 py-2">
                <label for="screenDropdown" class="block text-sm font-medium"> Screen </label>

                <select
                    name="screenDropdown"
                    id="screenDropdown"
                    class="mt-1.5 py-3 px-2 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
                    <option value="" disabled selected>Select a screen</option>

                </select>
            </div>
            <div class="w-full text-white p-4 py-2">
                <label for="showDropdown" class="block text-sm font-medium"> Show </label>

                <select
                    name="showDropdown"
                    id="showDropdown"
                    class="mt-1.5 py-3 px-2 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
                    <option value="" disabled selected>Select a show</option>
                </select>
            </div>
            <div class="w-full text-white p-4 py-2">
                <label
                    for="movie"
                    class="block overflow-hidden rounded-md  shadow-sm ">
                    <span class="block text-sm font-medium"> Movie </span>

                    <input
                        type="text"
                        id="movie"
                        disabled
                        placeholder="<?= $title ?>"
                        class="mt-1 py-3 px-2 w-full rounded-lg  border-none placeholder:text-gray-700 bg-white sm:text-sm" />
                </label>
            </div>
            <div class="w-full text-white p-4 py-2 mt-5">
                <div class="flex flex-col w-full justify-center gap-4 text-center mb-4 hidden" id="instructions">
                    <div class="flex text-center w-full justify-center gap-4">
                        <div class="text-lg border border-[#4A4947] bg-[#4A4947] p-2 rounded-lg min-w-[160px]">
                            <span class="text-white text-base">Reserved</span>
                        </div>
                        <div class="text-lg border border-[#1A1A1D]-2 p-2 rounded-lg min-w-[160px]">
                            <span class="text-white text-base">Not Reserved</span>
                        </div>
                        <div class="text-lg border border-[#008170] bg-[#008170] p-2 rounded-lg min-w-[160px]">
                            <span class="text-white text-base">Selected</span>
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="text-lg p-2 rounded-lg min-w-[160px]">
                            <span class="text-[#CC2B52] text-base">Price Per seat: $<span id="seat-price">0</span></span>
                        </div>
                    </div>
                </div>

                <div id="theatre" class="flex flex-col items-center gap-4"></div>
            </div>
        </div>
    </div>

</div>


<?php require_once '../includes/footer.php'; ?>

<script>
    let totalseats = 150;
    const maxColumns = 15;
    let totalColumns = maxColumns;
    let totalRows = Math.ceil(totalseats / totalColumns);
    let seatPrice = 0;
    let selectedSeats = [];
    let reservedSeats = [{
        seatId: "1B"
    }];

    function openModal(response) {
        const modal = document.createElement('div');
        const {
            user_id,
            show_id,
            selected_seats,
            total_price,
            payment_method,
            booking_id
        } = response.data;

        let titleTag = "";
        let descriptionTag = "";
        let actionButtons = "";

        if (response.status === "success") {
            titleTag = `<h2 class="text-2xl font-semibold text-green-400 w-full">Seats reversed successfully!</h2>`;
            descriptionTag = `
            <p class="mt-2 text-gray-600 w-full py-2">
                You reserved seats successfully.
            </p>
            
        `;
            actionButtons = `
            <div class="flex justify-center w-full mt-6">
                <button onclick="bookingPage('${booking_id}')" class="px-6 py-2 w-full bg-blue-200 text-gray-950 rounded-lg hover:bg-gray-300">Pay now</button>
            </div>
        `;
        } else {
            titleTag = `<h2 class="text-2xl font-semibold text-red-400 w-full">Error</h2>`;
            descriptionTag = `
            <p class="mt-2 text-gray-600 w-full py-2">
                There was an error with your seats reservation. Please try again later.
            </p>
            <p class="mt-4 text-gray-600 w-full py-2"><strong>Error Message:</strong> ${response.message}</p>
        `;
            actionButtons = `
            <div class="flex justify-center w-full mt-6">
                <button onclick="window.location.reload()" class="px-6 py-2 w-full bg-red-200 text-gray-950 rounded-lg hover:bg-gray-300">Try Again</button>
            </div>
        `;
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

    function bookingPage(response) {
        window.location.href = `./payment.php?movie_id=<?= $movie_id?>&&booking_id=${response}`;
    }



    function bookMovie() {
        let totalPrice = 0;
        selectedSeats.forEach(seat => {
            if (seat.type === "VIP") {
                totalPrice += seatPrice * 2;
            } else {
                totalPrice += seatPrice;
            }
        });

        const cinemaId = $("#cinemaDropdown").val();
        const screenId = $("#screenDropdown").val();
        const showId = $("#showDropdown").val();

        let seats = selectedSeats.map(seat => {
            return {
                seat: seat.seatId,
                type: seat.type
            };
        });

        if (selectedSeats.length === 0) {
            alert("Please select at least one seat!");
            return;
        }

        const bookingData = {
            cinema_id: cinemaId,
            screen_id: screenId,
            show_id: showId,
            selected_seats: seats,
            total_price: totalPrice
        };

        $.ajax({
            url: "../controllers/book_seats.php",
            method: "POST",
            data: bookingData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    console.log("Booking successful:", response.message);
                    // window.location.href = './payment.php?movie_id=<?= $movie_id ?>';
                    openModal(response);
                    // alert("Booking created successfully! Total Price: " + response.data.total_price);
                } else {
                    console.error("Booking error:", response.message);
                    openModal(response); // Open error modal
                    // alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error booking movie:", status, error);
                alert("Something went wrong. Please try again later.");
            }
        });
    }


    function cancelMovie() {
        window.location.href = './movie.php?id=<?= $movie_id ?>'
    }

    function generateColumnLabels(count) {
        const labels = [];
        for (let i = 0; i < count; i++) {
            let label = '';
            let current = i;

            while (current >= 0) {
                label = String.fromCharCode((current % 26) + 65) + label;
                current = Math.floor(current / 26) - 1;
            }
            labels.push(label);
        }
        return labels;
    }

    function toggleSeatSelection(seatId, row, column, type, seatElement) {
        const seatIndex = selectedSeats.findIndex((seat) => seat.seatId === seatId);

        if (seatIndex === -1) {
            selectedSeats.push({
                row,
                column,
                seatId,
                type,
            });
            seatElement.classList.add("selected");

            if (type === "VIP") {
                seatElement.classList.add("vip-seat");
            }
        } else {
            selectedSeats.splice(seatIndex, 1);
            seatElement.classList.remove("selected");

            if (type === "VIP") {
                seatElement.classList.remove("vip-seat");
            }
        }

        updateBookingUI();
        console.log("Selected Seats:", selectedSeats);
    }


    function getRowType(row) {
        const totalVIPRows = 3;
        return row <= totalVIPRows ? "VIP" : "Standard";
    }

    function updateBookingUI() {
        const bookedSeatsContainer = document.getElementById("booked-seats");
        const seatsPriceElement = document.getElementById("seats-price");

        bookedSeatsContainer.innerHTML = '';

        let totalPrice = 0;

        selectedSeats.forEach(seat => {
            const seatDiv = document.createElement('div');
            seatDiv.classList.add('selected-seat', 'flex', 'items-center', 'justify-between', 'w-full', 'border-gray-600', 'border-2', 'text-white', 'gap-4');
            let seatPrices = seat.type === "VIP" ? seatPrice * 2 : seatPrice;
            totalPrice += seatPrices;


            seatDiv.innerHTML = `
            <div class="flex items-center justify-between py-5 px-6 text-white gap-4">
                <h1 class="text-2xl"><span class="seat-row">${seat.row}</span><span class="text-sm"> row</span></h1>
                <h1 class="text-2xl"><span class="seat-number">${seat.column}</span><span class="text-sm">th seat</span></h1>
                <h1 class="text-xl">${seat.type} ($${seatPrices})</h1>
            </div>
            <div class="h-full flex items-center px-4">
                <button class="cancel-seat p-2 hover:text-red-500" onclick="cancelSeat('${seat.seatId}')">Cancel</button>
            </div>
        `;

            bookedSeatsContainer.appendChild(seatDiv);
        });

        seatsPriceElement.innerHTML = totalPrice ?
            `<span>Selected: ${selectedSeats.length}x</span><span>Total: $${totalPrice}</span>` :
            '';
    }

    function cancelSeat(seatId) {
        selectedSeats = selectedSeats.filter(seat => seat.seatId !== seatId);

        const seatElement = document.querySelector(`.seat-${seatId}`);
        if (seatElement) {
            seatElement.classList.remove("selected");
        }

        updateBookingUI();
    }

    function createTheatre() {
        const theatre = document.getElementById("theatre");
        const columnLabels = generateColumnLabels(totalColumns);

        const screen = document.createElement("div");
        screen.className = "screen w-full max-w-3xl";
        screen.textContent = " Screen ";
        theatre.appendChild(screen);

        const columnLabelsRow = document.createElement("div");
        columnLabelsRow.style.display = "grid";
        columnLabelsRow.style.gridTemplateColumns = `40px repeat(${totalColumns}, 40px)`;
        columnLabelsRow.style.gap = "4px";
        columnLabelsRow.className = "justify-center items-center mr-8 w-full max-w-3xl";

        const emptyCell = document.createElement("div");
        emptyCell.className = "seat-label seat bg-transparent";
        columnLabelsRow.appendChild(emptyCell);

        columnLabels.forEach((label) => {
            const colLabel = document.createElement("div");
            colLabel.className = "seat-label seat";
            colLabel.textContent = label;
            columnLabelsRow.appendChild(colLabel);
        });
        theatre.appendChild(columnLabelsRow);

        let seatCount = 0;
        for (let row = 1; row <= totalRows; row++) {
            const rowDiv = document.createElement("div");
            rowDiv.style.display = "grid";
            rowDiv.style.gridTemplateColumns = `40px repeat(${totalColumns}, 40px)`;
            rowDiv.style.gap = "4px";
            rowDiv.className = "w-full justify-center items-center mr-8 max-w-3xl";

            const rowLabel = document.createElement("div");
            rowLabel.className = "seat-label seat";
            rowLabel.textContent = `${row}`;
            rowDiv.appendChild(rowLabel);

            const rowType = getRowType(row);
            for (let col = 0; col < totalColumns; col++) {
                if (seatCount >= totalseats) break;

                const seat = document.createElement("div");
                const seatId = `${row}${columnLabels[col]}`;
                seat.className = `seat seat-space seat-${seatId}`;
                seat.textContent = ' ';

                if (reservedSeats.some(reserved => reserved.seatId === seatId)) {
                    seat.classList.add("reserved");
                } else {
                    seat.addEventListener("click", () => {
                        toggleSeatSelection(seatId, row, columnLabels[col], rowType, seat);
                    });

                    if (rowType === "VIP") {
                        seat.classList.add("vip-seat");
                    }
                }

                rowDiv.appendChild(seat);
                seatCount++;
            }

            theatre.appendChild(rowDiv);
        }
    }



    $("#cinemaDropdown").change(function() {
        const cinemaId = $(this).val();

        selectedSeats = [];
        updateBookingUI();

        fetchScreens(cinemaId, <?= $movie_id ?>);
    });

    $("#screenDropdown").change(function() {
        const screenId = $(this).val();
        const cinemaId = $("#cinemaDropdown").val();

        selectedSeats = [];
        updateBookingUI();

        fetchShows(screenId, <?= $movie_id ?>, cinemaId);
    });

    $("#showDropdown").change(function() {
        const showId = $(this).val();
        const screenId = $("#screenDropdown").val();
        const cinemaId = $("#cinemaDropdown").val();

        selectedSeats = [];
        updateBookingUI();

        fetchSeats(showId, screenId, cinemaId, <?= $movie_id ?>);
    });

    function fetchScreens(cinemaId, movieId) {
        $.ajax({
            url: `../controllers/fetch_screens.php`,
            method: "GET",
            data: {
                cinema_id: cinemaId,
                movie_id: movieId
            },
            dataType: "json",
            success: function(data) {
                const screenDropdown = $("#screenDropdown");
                screenDropdown.html('<option value="" disabled selected>Select a Screen</option>');
                data.forEach(screen => {
                    screenDropdown.append(`<option value="${screen.screen_id}">${screen.screen_name}</option>`);
                });
                screenDropdown.prop("disabled", false);
            },
            error: function() {
                alert("Failed to fetch screens.");
            }
        });
    }

    function fetchShows(screenId, movieId, cinemaId) {
        $.ajax({
            url: `../controllers/fetch_shows.php`,
            method: "GET",
            data: {
                screen_id: screenId,
                movie_id: movieId,
                cinema_id: cinemaId
            },
            dataType: "json",
            success: function(data) {
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
                const showDropdown = $("#showDropdown");
                showDropdown.html('<option value="" disabled selected>Select a Show</option>');
                data.forEach(show => {
                    let formatedStartTime = formatTime(show.show_time)
                    let formatedEndTime = formatTime(show.show_end)
                    showDropdown.append(`<option value="${show.show_id}">${formatedStartTime} - ${formatedEndTime}</option>`);
                });
                showDropdown.prop("disabled", false);
            },
            error: function() {
                alert("Failed to fetch shows.");
            }
        });
    }

    function fetchSeats(showId, screenId, cinemaId, movieId) {
        $.ajax({
            url: `../controllers/fetch_seats.php`,
            method: "GET",
            data: {
                show_id: showId,
                screen_id: screenId,
                cinema_id: cinemaId,
                movie_id: movieId
            },
            dataType: "json",
            success: function(data) {
                console.log("Seats Data:", data);
                totalseats = data.total_seats;
                totalColumns = maxColumns;
                totalRows = Math.ceil(totalseats / totalColumns);
                seatPrice = parseFloat(data.price);
                console.log(seatPrice);

                $('#seat-price').html(seatPrice)
                reservedSeats = data.seats
                    .filter(seat => seat.status === 'Reserved')
                    .map(seat => ({
                        seatId: seat.seat_number
                    }));


                let availableSeats = data.seats
                    .filter(seat => seat.status === 'Available')
                    .map(seat => seat.seat_number);

                console.log("Reserved Seats:", reservedSeats);
                $('#theatre').html(' ');
                $('#instructions').removeClass('hidden');
                $('#seats-details').removeClass('hidden');
                createTheatre();
            },
            error: function() {
                alert("Failed to fetch seats.");
            }
        });
    }
</script>

</body>

</html>