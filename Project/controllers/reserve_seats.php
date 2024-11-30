<?php
require_once './config.php'; 

if (!isset($_POST['seats']) || empty($_POST['seats']) || !isset($_POST['movie_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Seats and movie_id are required.']);
    exit;
}

$seats = $_POST['seats']; // Array of seat IDs
$movie_id = intval($_POST['movie_id']);
$user_id = 1; // For simplicity, we assume user_id is hardcoded (you can replace with session variable for logged-in user)
$total_price = 0; // Placeholder for total price (calculate based on selected seats)

// Fetch prices and mark seats as Reserved
$seat_ids = implode(',', array_map('intval', $seats)); // Sanitize seat IDs

// Query to get seat details
$query = "
    SELECT seat_id, price 
    FROM seats 
    WHERE seat_id IN ($seat_ids) AND status != 'Reserved'"; // Ensure these seats are not already reserved
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== count($seats)) {
    http_response_code(400); // Some seats are already reserved
    echo json_encode(['error' => 'One or more selected seats are already reserved.']);
    exit;
}

// Calculate the total price
while ($row = $result->fetch_assoc()) {
    $total_price += $row['price'];
}

$query = "
    INSERT INTO bookings (user_id, show_id, total_price, status) 
    VALUES (?, (SELECT show_id FROM shows WHERE movie_id = ? LIMIT 1), ?, 'Pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param('iii', $user_id, $movie_id, $total_price);
$stmt->execute();
$booking_id = $stmt->insert_id; // Get the inserted booking ID

// Insert into booking_seats table
$query = "
    INSERT INTO booking_seats (booking_id, seat_id) 
    VALUES (?, ?)";
$stmt = $conn->prepare($query);

foreach ($seats as $seat_id) {
    $stmt->bind_param('ii', $booking_id, $seat_id);
    $stmt->execute();
}

// Mark seats as Reserved
$query = "UPDATE seats SET status = 'Reserved' WHERE seat_id IN ($seat_ids)";
$stmt = $conn->prepare($query);
$stmt->execute();

// Respond with success
echo json_encode(['success' => true, 'message' => 'Booking successful!']);

$stmt->close();
$conn->close();
?>
