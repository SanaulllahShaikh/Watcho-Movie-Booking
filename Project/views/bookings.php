<?php
$page = "bookings";
include('../includes/header.php');
?>

<div class="primary-container min-h-screen flex flex-col gap-6 mx-auto w-full p-6 bg-gray-800">
    <h1 class="font-bold text-4xl text-gray-100 pt-5 pb-4 border-b border-gray-600 tracking-wide uppercase">
        Bookings
    </h1>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700 bg-gray-900 text-sm text-gray-300">
            <thead class="text-center bg-gray-800">
                <tr>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-200">Poster</th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-200">Movie Title</th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-200">Booking Date</th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-200">Show Time</th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-200">Total Price</th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-200">Status</th>
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-200">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-700">
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500 text-lg h-[50vh]">Not Logged in.</td>
                </tr>
                <!-- <tr>
                        <td class="whitespace-nowrap px-4 py-2 overflow-hidden rounded-full">
                            <img src="../assets/images/extraction2.png" alt="Inception Poster"
                                class="w-16 h-24  object-cover rounded">
                        </td>
                        <td class="whitespace-nowrap px-4 py-2 font-medium">Extraction 2 </td>
                        <td class="whitespace-nowrap px-4 py-2">2024-10-24</td>
                        <td class="whitespace-nowrap px-4 py-2">7:00 PM</td>
                        <td class="whitespace-nowrap px-4 py-2">$15.00</td>
                        <td class="whitespace-nowrap px-4 py-2 text-green-400">Confirmed</td>
                        <td class="whitespace-nowrap px-4 py-2 space-x-2 text-center">
                            <a href="#"
                                class="inline-block rounded bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700">
                                View Movie
                            </a>
                            <a href="#"
                                class="inline-block rounded bg-indigo-600 px-3 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                                Booking Details
                            </a>
                        </td>
                    </tr> -->

            </tbody>
        </table>
    </div>
</div>






<!-- FOOTER  -->

<?php require_once '../includes/footer.php'; ?>

<?php

if (!isset($_SESSION['user_id'])) {
    echo '
    </body>
</html>
';

    exit;
}


?>


<script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuBtn.classList.toggle('active-btn');
        menuBtn.classList.toggle('text-black');
    });

    $.ajax({
        url: '../controllers/fetch_bookings.php',
        type: 'GET',
        data: {
            user_id: <?=
                        isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false
                        ?>
        },
        success: function(response) {
            try {
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
                        month: 'numeric',
                        day: 'numeric'
                    };
                    return new Intl.DateTimeFormat('en-US', options).format(date);
                }
                const result = JSON.parse(response);

                if (result.success) {
                    const bookings = result.bookings;

                    if (bookings.length > 0) {
                        let tableRows = '';
                        bookings.forEach(function(booking) {
                            let bookingPoster = '';

                            if (booking.poster_url.substring(0, 4) !== 'http') {
                                bookingPoster = '.' + booking.poster_url;
                            } else {
                                bookingPoster = booking.poster_url;
                            }


                            const formatedShowTime = formatTime(booking.show_time);
                            const formatedDate = formatDate(booking.booking_date.split(' ', 2)[0]);
                            const formatedTime = formatTime(booking.booking_date.split(' ', 2)[1]);
                            const booking_date = formatedDate + ' ' + formatedTime;

                            tableRows += `
                                <tr id="booking-${booking.booking_id}">
                                    <td class="whitespace-nowrap px-4 py-2 overflow-hidden flex justify-center rounded-full">
                                        <img src="${bookingPoster}" alt="${booking.movie_title} Poster" class="w-16 h-24 rounded-xl object-cover rounded">
                                    </td>
                                    <td class="whitespace-nowrap px-4 text-start py-2 font-medium">${booking.movie_title}</td>
                                    <td class="whitespace-nowrap px-4 text-center py-2">${booking_date}</td>
                                    <td class="whitespace-nowrap px-4 text-center py-2">${formatedShowTime}</td>
                                    <td class="whitespace-nowrap px-4 text-center py-2">$${booking.total_price}</td>
                                    <td class="whitespace-nowrap px-4 text-center py-2 text-${booking.status === 'Confirmed' ? 'green' : booking.status === 'Pending' ? 'yellow' : 'red'}-400">${booking.status}</td>
                                    <td class="whitespace-nowrap px-4 text-center py-2 space-x-2 text-center">
                                        <a href="./movie.php?id=${booking.movie_id}" class="inline-block rounded bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700">
                                            View Movie
                                        </a>
                                        <a href="./payment.php?movie_id=${booking.movie_id}&&booking_id=${booking.booking_id}" class="inline-block rounded bg-green-600 px-3 py-2 text-xs font-medium text-white hover:bg-green-700">
                                            Payment
                                        </a>
                                        <button onclick="deleteBooking('${booking.booking_id}')" class="inline-block rounded bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700">
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });

                        $('tbody').html(tableRows);
                    } else {
                        $('tbody').html('<tr><td colspan="7" class="text-center py-4 text-gray-500 text-lg h-[50vh]">No bookings found.</td></tr>');
                    }
                } else {
                    console.error('Error fetching bookings:', result.message);
                }
            } catch (e) {
                console.error('Error parsing response:', e);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching bookings:', error);
        }
    });


    function deleteBooking(bookingId) {
        if (confirm("Are you sure you want to cancel this booking?")) {
            $.ajax({
                url: "../controllers/delete_booking.php",
                method: "POST",
                data: {
                    booking_id: bookingId
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        document.getElementById(`booking-${bookingId}`).remove();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting booking:", status, error);
                    alert("Something went wrong. Please try again later.");
                }
            });
        }
    }
</script>
</body>

</html>