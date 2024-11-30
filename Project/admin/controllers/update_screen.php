<?php
require_once '../../controllers/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $screen_id = $_POST['screen_id'];
    $cinema_id = $_POST['cinema_id'];
    $screen_name = $_POST['screen_name'];
    $total_seats = $_POST['total_seats'];
    $screen_type = $_POST['screen_type'];

    if (empty($screen_name) || empty($cinema_id) || empty($total_seats) || empty($screen_type)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
        exit;
    }

    $query = "UPDATE screens SET screen_name = ?, screen_type = ?, total_seats = ? WHERE screen_id = ? AND cinema_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssiii', $screen_name, $screen_type, $total_seats, $screen_id, $cinema_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Screen updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update screen.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
