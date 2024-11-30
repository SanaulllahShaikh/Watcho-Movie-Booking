<?php
require_once './config.php';
$screen_id = $_GET['screen_id'];
$movie_id = $_GET['movie_id'];

$query = "SELECT show_id, show_time, show_end FROM shows WHERE screen_id = ? and movie_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $screen_id, $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$shows = [];
while ($row = $result->fetch_assoc()) {
    $shows[] = $row;
}
echo json_encode($shows);
?>
