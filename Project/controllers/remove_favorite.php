<?php
session_start();
require_once './config.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$movie_id = $_GET['movie_id'] ?? null;
if (!$movie_id) {
    echo json_encode(['success' => false, 'message' => 'Movie ID is required']);
    exit();
}

$query = "DELETE FROM favorites WHERE user_id = ? AND movie_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $user_id, $movie_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Movie removed from favorites']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Movie not found in favorites']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error removing movie from favorites']);
}

$conn->close();
?>
