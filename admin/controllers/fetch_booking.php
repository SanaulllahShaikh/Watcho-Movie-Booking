<?php
include '../../controllers/config.php';

$query = "
    SELECT b.booking_id, b.user_id, s.show_date, m.title AS movie_title, b.booking_date, b.status, b.seat_ids 
    FROM bookings b
    JOIN shows s ON b.show_id = s.show_id
    JOIN movies m ON s.movie_id = m.movie_id
";

$result = mysqli_query($conn, $query);

$bookings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['seat_ids'] = explode(',', $row['seat_ids']);
    $bookings[] = $row;
}

echo json_encode($bookings);
?>
