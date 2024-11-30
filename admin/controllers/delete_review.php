<?php
include('../../controllers/config.php');

if (isset($_GET['review_id'])) {
    $review_id = $_GET['review_id'];

    $query = "DELETE FROM reviews WHERE review_id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $review_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Review deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete review']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Review ID not provided']);
}
