<?php
$page = "seat_book";
include('../includes/header.php');
require_once '../controllers/config.php';

$movie_id = $_GET['movie_id'];
$booking_id = $_GET['booking_id'];

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
$sql = "
SELECT b.booking_id, m.title, sh.price AS movie_price, s.seat_number, s.price AS seat_price, b.seat_ids
FROM bookings b
JOIN shows sh ON b.show_id = sh.show_id
JOIN movies m ON sh.movie_id = m.movie_id
JOIN seats s ON s.show_id = b.show_id
WHERE b.booking_id = ? AND m.movie_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $booking_id, $movie_id);
$stmt->execute();
$result = $stmt->get_result();

$booking_details = $result->fetch_all(MYSQLI_ASSOC);

$seat_ids = json_decode($booking_details[0]['seat_ids'], true);

$total_price = 0;
$seats = [];
foreach ($seat_ids as $seat) {
    $seats[] = $seat['seat'];
    foreach ($booking_details as $detail) {
        if ($detail['seat_number'] == $seat['seat']) {
            if ($seat['type'] == 'VIP') {
                $total_price += $detail['seat_price'] * 2;
            } else {
                $total_price += $detail['seat_price'];
            }
        }
    }
}

$selected_seats = implode(', ', $seats);


$stmt->close();
$conn->close();


?>


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
                                class="shrink-0 border border-transparent p-3 w-[200px] flex-col lg:w-[200px] xl:w-[260px] text-md font-medium text-gray-500 hover:text-gray-700 text-gray-400  hover:text-gray-200">
                                <span class="py-1 px-3 bg-gray-600 rounded-md text-zinc-300 mr-2">2</span>
                                CHOOSE YOU'RE PLACE
                            </button>

                            <button
                                class="shrink-0 text-upper border-b-4 border-red-600 p-3 w-[200px] flex-col lg:w-[200px] xl:w-[260px] text-md font-medium text-sky-600 border-gray-600 border-b-red-600 text-gray-300">
                                <span class="py-1 px-3 bg-gray-600 rounded-md text-zinc-300 mr-2">1</span>
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
            <div class="mx-auto">
                <h2 class="text-xl font-semibold text-white sm:text-2xl mt-8">Payment</h2>

                <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-6">
                    <form id="payment-form" method="POST" class="w-full rounded-lg border border-gray-700 bg-gray-800 p-4 shadow-sm sm:p-6 lg:max-w-xl lg:p-8">
                        <div class="mb-6 grid grid-cols-2 gap-4">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="full_name" class="mb-2 block text-sm font-medium text-white">Full name (as displayed on card)*</label>
                                <input type="text" id="full_name" name="full_name" class="block w-full rounded-lg border border-gray-600 bg-gray-700 p-2.5 text-sm text-white focus:border-primary-500 focus:ring-primary-500 placeholder:text-gray-400" placeholder="Bonnie Green" />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="card-number-input" class="mb-2 block text-sm font-medium text-white">Card number*</label>
                                <input type="text" id="card-number-input" name="card_number" class="block w-full rounded-lg border border-gray-600 bg-gray-700 p-2.5 pe-10 text-sm text-white focus:border-primary-500 focus:ring-primary-500 placeholder:text-gray-400" placeholder="xxxx-xxxx-xxxx-xxxx" pattern="^4[0-9]{12}(?:[0-9]{3})?$" />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="email" class="mb-2 block text-sm font-medium text-white">Email Address*</label>
                                <input type="email" id="email" name="email" class="block w-full rounded-lg border border-gray-600 bg-gray-700 p-2.5 text-sm text-white focus:border-primary-500 focus:ring-primary-500 placeholder:text-gray-400" placeholder="example@email.com" />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="expiry-date" class="mb-2 block text-sm font-medium text-white">Expiration Date*</label>
                                <input type="month" id="expiry-date" name="expiry_date" class="block w-full rounded-lg border border-gray-600 bg-gray-700 p-2.5 text-sm text-white focus:border-primary-500 focus:ring-primary-500" />
                            </div>

                            <input type="hidden" id="booking-id" name="booking_id" value="<?= $_GET['booking_id'] ?>" />

                            <div class="col-span-2 sm:col-span-1">
                                <label for="cvv" class="mb-2 block text-sm font-medium text-white">CVV*</label>
                                <input type="text" id="cvv" name="cvv" class="block w-full rounded-lg border border-gray-600 bg-gray-700 p-2.5 text-sm text-white focus:border-primary-500 focus:ring-primary-500 placeholder:text-gray-400" placeholder="123" pattern="^[0-9]{3,4}$" />
                            </div>

                            <div class="col-span-2">
                                <label for="billing-address" class="mb-2 block text-sm font-medium text-white">Billing Address*</label>
                                <textarea id="billing-address" name="billing_address" class="block w-full rounded-lg border border-gray-600 bg-gray-700 p-2.5 text-sm text-white focus:border-primary-500 focus:ring-primary-500 placeholder:text-gray-400" rows="3" placeholder="123 Main St, City, Country"></textarea>
                            </div>
                        </div>

                        <div class="w-full text-white p-4 py-2 mt-5 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm">Payment Method: Credit Card</span>
                            </div>
                            <button type="submit" class="w-full py-3 bg-[#008170] rounded-lg text-white font-semibold text-lg hover:bg-[#006f5f] focus:outline-none focus:ring-2 focus:ring-[#008170]">
                                Confirm Payment
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 grow sm:mt-8 lg:mt-0">
                        <div class="space-y-4 rounded-lg border border-gray-700 bg-gray-800 p-6">
                            <div class="space-y-2">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-400">Selected Seats</dt>
                                    <dd class="text-base font-medium text-white"><?= $selected_seats ?></dd>
                                </dl>

                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-400">Total price</dt>
                                    <dd class="text-base font-medium text-white">$<?= number_format($total_price, 2) ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


<?php require_once '../includes/footer.php'; ?>
<script>
    $('#payment-form').on('submit', function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        formData += '&booking_id=' + $('#booking-id').val();

        $.ajax({
            url: '../controllers/payment.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    alert('Payment successful!');
                    window.location.href = './bookings.php';
                } else {
                    alert('Payment failed. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            }
        });
    });
</script>

</body>

</html>