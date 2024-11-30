<?php
require_once './config.php';

if (
    !isset($_GET['movie_id']) || empty($_GET['movie_id']) ||
    !isset($_GET['show_id']) || empty($_GET['show_id']) ||
    !isset($_GET['cinema_id']) || empty($_GET['cinema_id']) ||
    !isset($_GET['screen_id']) || empty($_GET['screen_id'])
) {
    echo json_encode(['error' => 'Movie ID, Show ID, Cinema ID, and Screen ID are required.']);
    exit;
}

$movie_id = $_GET['movie_id'];
$show_id = $_GET['show_id'];
$cinema_id = $_GET['cinema_id'];
$screen_id = $_GET['screen_id'];

// First query to fetch total_seats and price from the screens and shows tables
$totalSeatsAndPriceQuery = "
    SELECT 
        screens.total_seats, 
        shows.price
    FROM screens
    INNER JOIN shows ON screens.screen_id = shows.screen_id
    WHERE 
        shows.movie_id = ? 
        AND shows.show_id = ? 
        AND screens.cinema_id = ? 
        AND screens.screen_id = ?
";

$stmtTotalSeatsAndPrice = $conn->prepare($totalSeatsAndPriceQuery);
if (!$stmtTotalSeatsAndPrice) {
    echo json_encode(['error' => 'Prepared statement for total seats and price failed: ' . $conn->error]);
    exit;
}

$stmtTotalSeatsAndPrice->bind_param('iiii', $movie_id, $show_id, $cinema_id, $screen_id);
$stmtTotalSeatsAndPrice->execute();
$resultTotalSeatsAndPrice = $stmtTotalSeatsAndPrice->get_result();

if ($resultTotalSeatsAndPrice === false) {
    echo json_encode(['error' => 'Error executing total seats and price query: ' . $conn->error]);
    exit;
}

$totalSeats = 0;
$price = 0.00;
if ($rowTotalSeatsAndPrice = $resultTotalSeatsAndPrice->fetch_assoc()) {
    $totalSeats = $rowTotalSeatsAndPrice['total_seats'];
    $price = $rowTotalSeatsAndPrice['price'];
}

// Second query to fetch seat details
$seatsQuery = "
    SELECT 
        seat_id,
        seat_number,
        status AS seat_status
    FROM seats 
    WHERE 
        show_id = ?
        AND screen_id = ?
";

$stmtSeats = $conn->prepare($seatsQuery);
if (!$stmtSeats) {
    echo json_encode(['error' => 'Prepared statement for seats failed: ' . $conn->error]);
    exit;
}

$stmtSeats->bind_param('ii', $show_id, $screen_id);
$stmtSeats->execute();
$resultSeats = $stmtSeats->get_result();

if ($resultSeats === false) {
    echo json_encode(['error' => 'Error executing seats query: ' . $conn->error]);
    exit;
}

$seats = [];
while ($rowSeats = $resultSeats->fetch_assoc()) {
    $seats[] = [
        'seat_id' => $rowSeats['seat_id'],
        'seat_number' => $rowSeats['seat_number'],
        'status' => $rowSeats['seat_status']
    ];
}

echo json_encode([
    'total_seats' => $totalSeats,
    'price' => $price,
    'seats' => $seats
]);

$stmtTotalSeatsAndPrice->close();
$stmtSeats->close();
$conn->close();