<?php
header('Content-Type: application/json');
include_once '../../controllers/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cinema_id']) && !empty($_POST['cinema_id'])) {
        $cinemaId = $_POST['cinema_id'];

        $sql = "DELETE FROM cinemas WHERE cinema_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cinemaId); 

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete cinema.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Cinema ID is missing.']);
    }

    $conn->close();
}
