<?php
require_once '../../controllers/config.php';
header('Content-Type: application/json');

$genre_id = $_POST['genre_id'];
$query = "DELETE FROM genres WHERE genre_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $genre_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Genre deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete genre.']);
}
$stmt->close();
$conn->close();
