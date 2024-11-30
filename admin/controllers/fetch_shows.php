<?php
header('Content-Type: application/json');
include_once '../../controllers/config.php';

$sql = "
    SELECT shows.show_id, shows.show_time as show_start, shows.show_date as show_date, shows.show_end, movies.title AS movie_name, 
           cinemas.cinema_name, screens.screen_name, shows.price as seat_price
    FROM shows
    INNER JOIN movies ON shows.movie_id = movies.movie_id
    INNER JOIN screens ON shows.screen_id = screens.screen_id
    INNER JOIN cinemas ON screens.cinema_id = cinemas.cinema_id
    ORDER BY shows.show_time ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $shows = [];
    while ($row = $result->fetch_assoc()) {
        $shows[] = $row;
    }
    echo json_encode(['error' => false, 'shows' => $shows]);
} else {
    echo json_encode(['error' => true, 'message' => 'No shows available.']);
}

$conn->close();
?>
