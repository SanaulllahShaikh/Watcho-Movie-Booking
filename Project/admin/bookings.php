<?php
$active_tab = 'bookings';
include './includes/header.php';
?>

<div class="flex-grow px-6">
    <main class="text-[#FEF9F2]">
        <div class="px-8 py-6 flex items-center justify-between border-b border-gray-800">
            <h1 class="text-3xl font-base">USER BOOKINGS</h1>
            <div class="relative">
                <input type="text" id="searchBooking" placeholder="Search by movie title"
                    class="w-80 py-2 pr-16 pl-6 rounded-full border border-gray-700 bg-[#222831] text-white placeholder-gray-400 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#CC2B52]">
                <button
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 text-[#CC2B52] h-full pl-4 pr-6 rounded-r-full transition duration-300 hover:bg-[#CC2B52] hover:text-white ">
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
                        <th class="py-3 px-4 text-center text-xs font-normal">Booking ID</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">User ID</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">Movie Title</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">Show Date</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">Seats Booked</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">Booking Date</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">Status</th>
                        <th class="py-3 px-4 text-center text-xs font-normal">Actions</th>
                    </tr>
                </thead>
                <tbody id="bookingsBody">
                    <!-- Data will be appended here dynamically -->
                </tbody>
            </table>
        </div>
    </main>
</div>

<script>
    $.ajax({
        url: './controllers/fetch_booking.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#bookingsBody').empty();

            if (data.length <= 0) {
                let bookingRow = `
                        <tr>
                         <td class="py-5 px-4 text-center text-md" colspan="8">No bookings found</td>
                        </tr>
                    `;
                $('#bookingsBody').append(bookingRow);
            }

            data.forEach(function(booking) {
                let cleanedSeatIds = booking.seat_ids.map(function(seat) {
                    return seat.replace(/"/g, '');
                });
                let seat_ids = cleanedSeatIds.join(',');


                const bookingRow = `
                        <tr class="bg-[#021526]" id="bookingRow${booking.booking_id}">
                            <td class="py-5 px-4 text-center text-md">${booking.booking_id}</td>
                            <td class="py-5 px-4 text-center text-md">${booking.user_id}</td>
                            <td class="py-5 px-4 text-center text-md">${booking.movie_title}</td>
                            <td class="py-5 px-4 text-center text-md">${booking.show_date}</td>
                            <td class="py-5 px-4 text-center text-md">${seat_ids}</td>
                            <td class="py-5 px-4 text-center text-md">${booking.booking_date}</td>
                            <td class="py-5 px-4 text-center text-md">${booking.status}</td>
                            <td class="py-5 px-4 space-x-2 flex items-center justify-center">
                                <button onclick="cancelBooking(${booking.booking_id})" class="bg-[#821131] text-[#CC2B52] p-1 rounded-md transition duration-300 hover:bg-[#800000]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM9 11H11V17H9V11ZM13 11H15V17H13V11ZM9 4V6H15V4H9Z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    `;
                $('#bookingsBody').append(bookingRow);
            });

            document.getElementById("searchBooking").addEventListener("input", function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll("#bookingsBody tr");

                rows.forEach((row) => {
                    const movieTitle = row.children[2].textContent.toLowerCase();
                    if (movieTitle.includes(searchValue)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });

        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', error);
        }
    });

    function cancelBooking(bookingId) {
        if (confirm("Are you sure you want to cancel this booking?")) {
            $.ajax({
                url: './controllers/cancel_booking.php',
                method: 'POST',
                data: {
                    booking_id: bookingId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $(`#bookingRow${bookingId}`).fadeOut();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', error);
                    alert("An error occurred while trying to cancel the booking.");
                }
            });
        }
    }
</script>
</body>

</html>