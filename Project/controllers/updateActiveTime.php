<?php
include('./config.php');

$user_id = $_POST['user_id'];

if (isset($user_id)) {
    $query = "UPDATE sessions SET last_active = NOW() WHERE user_id = ? ORDER BY last_active DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to update last_active"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "User not authenticated"]);
}
