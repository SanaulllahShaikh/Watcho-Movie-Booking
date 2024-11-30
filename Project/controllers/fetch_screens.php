<?php
require_once './config.php';

$cinema_id = $_GET['cinema_id'];
$movie_id = $_GET['movie_id'];

$query = "
    SELECT DISTINCT screens.screen_id, screens.screen_name 
    FROM screens
    INNER JOIN shows ON screens.screen_id = shows.screen_id
    WHERE screens.cinema_id = ? AND shows.movie_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $cinema_id, $movie_id);
$stmt->execute();
$result = $stmt->get_result();

$screens = [];
while ($row = $result->fetch_assoc()) {
    $screens[] = $row;
}

echo json_encode($screens);

$stmt->close();
$conn->close();
?>
