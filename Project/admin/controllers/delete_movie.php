<?php
include_once '../../controllers/config.php';

if (isset($_POST['movie_id'])) {
    $movie_id = intval($_POST['movie_id']);

    $query = "DELETE FROM movies WHERE movie_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $movie_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Movie deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete movie']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No movie ID provided']);
}

$conn->close();
?>
