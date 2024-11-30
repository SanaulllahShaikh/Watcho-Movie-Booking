<?php
include_once './config.php';

session_start();

$user_id = $_SESSION['user_id'];

$query = "
    SELECT b.booking_id, b.booking_date, b.total_price, b.status, 
           m.title, m.poster_url, s.show_time, m.movie_id
    FROM bookings b
    JOIN shows s ON b.show_id = s.show_id
    JOIN movies m ON s.movie_id = m.movie_id
    WHERE b.user_id = ?;
";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $user_id);
    
    $stmt->execute();
    
    $stmt->bind_result($booking_id, $booking_date, $total_price, $status, $movie_title, $poster_url, $show_time, $movie_id);
    
    $bookings = [];
    
    while ($stmt->fetch()) {
        $bookings[] = [
            'booking_id' => $booking_id,
            'movie_id' => $movie_id,
            'booking_date' => $booking_date,
            'total_price' => $total_price,
            'status' => $status,
            'movie_title' => $movie_title,
            'poster_url' => $poster_url,
            'show_time' => $show_time
        ];
    }
    
    $stmt->close();
    
    echo json_encode(['success' => true, 'bookings' => $bookings]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch bookings.']);
}

$conn->close();
?>
