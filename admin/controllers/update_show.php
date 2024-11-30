<?php
include_once '../../controllers/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $show_id = $_POST['show_id'];
    $screen_id = $_POST['screen_id'];
    $movie_id = $_POST['movie_id'];
    $seat_price = $_POST['seat_price'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];
    $show_end = $_POST['show_end'];

    if (empty($show_id) || empty($screen_id) || empty($movie_id) || empty($show_date) || empty($show_time) || empty($show_end) || empty($seat_price)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $updateQuery = "
        UPDATE shows
        SET
            screen_id = ?, 
            movie_id = ?, 
            show_date = ?, 
            show_time = ?, 
            show_end = ?,
            price = ?
        WHERE show_id = ?;
    ";

    if ($stmt = $conn->prepare($updateQuery)) {
        $stmt->bind_param("issssii", $screen_id, $movie_id, $show_date, $show_time, $show_end, $seat_price, $show_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'Show updated successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No changes were made or show not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update the show.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL query.']);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
