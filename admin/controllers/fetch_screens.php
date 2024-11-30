<?php
header('Content-Type: application/json');
include_once '../../controllers/config.php';

if (isset($_POST['cinema_id']) && is_numeric($_POST['cinema_id'])) {
    $cinema_id = $_POST['cinema_id'];

    // Query to fetch screens and their shows
    $sql = "
        SELECT s.screen_id, s.screen_name, s.screen_type, s.total_seats, sh.show_id, sh.movie_id, sh.show_date, sh.show_time, sh.show_end 
        FROM screens s
        LEFT JOIN shows sh ON s.screen_id = sh.screen_id
        WHERE s.cinema_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cinema_id);

    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $screen_id = $row['screen_id'];
            // Group shows by screen
            if (!isset($data[$screen_id])) {
                $data[$screen_id] = [
                    'screen_id' => $screen_id,
                    'screen_name' => $row['screen_name'],
                    'screen_type' => $row['screen_type'],
                    'total_seats' => $row['total_seats'],
                    'shows' => []
                ];
            }

            // Add show details if available
            if (!empty($row['show_id'])) {
                $data[$screen_id]['shows'][] = [
                    'show_id' => $row['show_id'],
                    'movie_id' => $row['movie_id'],
                    'show_date' => $row['show_date'],
                    'show_time' => $row['show_time'],
                    'show_end' => $row['show_end']
                ];
            }
        }
    }

    echo json_encode(array_values($data));

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid or missing cinema_id']);
}

$conn->close();
?>
