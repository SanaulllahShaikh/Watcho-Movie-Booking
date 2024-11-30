<?php
include '../../controllers/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

$favorite_id = isset($_POST['favorite_id']) ? intval($_POST['favorite_id']) : 0;

if ($favorite_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid favorite ID.'
    ]);
    exit;
}

try {
    $query = "DELETE FROM favorites WHERE favorite_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $favorite_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Favorite removed successfully.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to remove favorite or favorite does not exist.'
        ]);
    }
} catch (Exception $e) {
    error_log("Error removing favorite: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while removing the favorite.'
    ]);
}
?>
