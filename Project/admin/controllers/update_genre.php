<?php
require_once '../../controllers/config.php';
header('Content-Type: application/json');

$genre_id = $_POST['genre_id'];
$genre_name = $_POST['genre_name'];

$query = "UPDATE genres SET genre_name = ? WHERE genre_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $genre_name, $genre_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Genre updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update genre.']);
}
$stmt->close();
$conn->close();
