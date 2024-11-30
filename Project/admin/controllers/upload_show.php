<?php
include '../../controllers/config.php';

$response = ['success' => false];

if (
    isset($_POST['cinema_id'], $_POST['screen_id'], $_POST['movie_id'], $_POST['show_date'], $_POST['show_time'], $_POST['show_end'], $_POST['seat_price'])
) {
    $cinema_id = $_POST['cinema_id'];
    $screen_id = $_POST['screen_id'];
    $movie_id = $_POST['movie_id'];
    $seat_price = $_POST['seat_price'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];
    $show_end = $_POST['show_end'];

    $insertQuery = "INSERT INTO shows (movie_id, screen_id, show_date, show_time, show_end, price) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iisssi", $movie_id, $screen_id, $show_date, $show_time, $show_end, $seat_price);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = "Database error: " . $stmt->error;
    }
} else {
    $response['message'] = 'Incomplete data.';
}

echo json_encode($response);
?>
