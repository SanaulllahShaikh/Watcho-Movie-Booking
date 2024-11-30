<?php
include '../../controllers/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;

    if ($booking_id > 0) {
        // Check if the booking exists
        $query = "SELECT * FROM bookings WHERE booking_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Delete the booking itself
            $deleteQuery = "DELETE FROM bookings WHERE booking_id = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $booking_id);

            if ($deleteStmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Booking deleted successfully.',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to delete booking.',
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Booking not found.',
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid booking ID.',
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.',
    ]);
}
