<?php
include '../../controllers/config.php';

try {
    $query = "
        SELECT 
            f.favorite_id, 
            f.user_id, 
            m.movie_id, 
            m.title AS movie_title, 
            m.release_date, 
            m.duration, 
            f.added_date,
            u.username AS user_name
        FROM favorites f
        JOIN movies m ON f.movie_id = m.movie_id
        JOIN users u ON f.user_id = u.user_id
        ORDER BY f.added_date DESC
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $favorites = [];
    while ($row = $result->fetch_assoc()) {
        $favorites[] = [
            'favorite_id' => $row['favorite_id'],
            'user_id' => $row['user_id'],
            'user_name' => $row['user_name'],
            'movie_id' => $row['movie_id'],
            'movie_title' => $row['movie_title'],
            'release_date' => $row['release_date'],
            'duration' => $row['duration'],
            'added_date' => $row['added_date']
        ];
    }

    echo json_encode($favorites);
} catch (Exception $e) {
    error_log("Error fetching all users' favorites: " . $e->getMessage());
    echo json_encode([]);
}
?>
