<?php
include_once '../../controllers/config.php';

$sql = "SELECT cinema_id, cinema_name, address, city, state, postal_code, contact_number, cinema_type FROM cinemas";
$result = $conn->query($sql);

$cinemas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cinemas[] = $row;
    }
}

echo json_encode($cinemas);

$conn->close();
?>
