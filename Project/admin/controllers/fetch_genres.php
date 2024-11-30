<?php
require_once '../../controllers/config.php';

header('Content-Type: application/json');

$query = "
    SELECT 
        g.genre_id, 
        g.genre_name, 
        COUNT(mg.movie_id) AS number_of_movies 
    FROM genres g
    LEFT JOIN movie_genres mg ON g.genre_id = mg.genre_id
    GROUP BY g.genre_id, g.genre_name
    ORDER BY g.genre_id ASC
";

$result = $conn->query($query);

if ($result) {
    $genres = [];
    while ($row = $result->fetch_assoc()) {
        $genres[] = [
            'id' => $row['genre_id'],
            'name' => $row['genre_name'],
            'movies_count' => $row['number_of_movies']
        ];
    }
    echo json_encode(['success' => true, 'data' => $genres]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch genres.']);
}

$conn->close();
