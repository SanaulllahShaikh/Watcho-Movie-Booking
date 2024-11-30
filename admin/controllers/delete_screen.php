<?php
header('Content-Type: application/json');
include_once '../../controllers/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['screen_id']) && !empty($_POST['screen_id'])) {
        $screen_id = $_POST['screen_id'];

        $sql = "DELETE FROM screens WHERE screen_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $screen_id); 

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete screen.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'screen ID is missing.']);
    }

    $conn->close();
}
