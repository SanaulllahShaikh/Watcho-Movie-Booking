<?php

require_once '../../controllers/config.php'; 

if (isset($_POST['show_id'])) {
    $show_id = intval($_POST['show_id']);

    $query = "DELETE FROM shows WHERE show_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $show_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete the show.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No show ID provided.']);
}

$conn->close();
?>
