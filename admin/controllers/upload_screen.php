<?php
require_once '../../controllers/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $screen_name = $_POST['screen_name'] ?? '';
    $cinema_id = $_POST['cinema_id'] ?? '';
    $total_seats = $_POST['total_seats'] ?? '';
    $screen_type = $_POST['screen_type'] ?? '';

    if (empty($screen_name) || empty($cinema_id) || empty($total_seats) || empty($screen_type)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
        exit;
    }

    $query = "INSERT INTO screens (cinema_id, screen_name, screen_type, total_seats) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('issi', $cinema_id, $screen_name, $screen_type, $total_seats);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Screen added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add screen.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
