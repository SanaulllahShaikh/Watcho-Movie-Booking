<?php
include '../../controllers/config.php';

if (isset($_GET['cinema_id'])) {
    $cinema_id = $_GET['cinema_id'];

    $screensQuery = "SELECT screen_id, screen_name FROM screens WHERE cinema_id = ?";
    $stmt = $conn->prepare($screensQuery);
    $stmt->bind_param("i", $cinema_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $screens = [];
    while ($screen = $result->fetch_assoc()) {
        $screens[] = $screen;
    }

    echo json_encode(['success' => true, 'screens' => $screens]);
} else {
    echo json_encode(['success' => false, 'message' => 'Cinema ID not provided.']);
}
?>
