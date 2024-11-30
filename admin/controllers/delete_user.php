<?php
require_once '../../controllers/config.php';

header('Content-Type: application/json');

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id']; 

    if ($user_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
        exit;
    }

    $query = "DELETE FROM users WHERE user_id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $user_id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No user found with the provided ID.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to execute the query.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL statement.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User ID is missing.']);
}

$conn->close();
