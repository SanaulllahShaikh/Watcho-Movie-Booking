<?php
include_once '../../controllers/config.php';

$sql = "
SELECT 
    u.user_id AS id, 
    u.username, 
    u.email, 
    COUNT(r.review_id) AS reviews, 
    age, 
    u.created_at AS joined, 
    u.status 
FROM 
    users u
LEFT JOIN 
    reviews r ON u.user_id = r.user_id
GROUP BY 
    u.user_id
ORDER BY 
    u.created_at DESC";

$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($users);

$conn->close();
