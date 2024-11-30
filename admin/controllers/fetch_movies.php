<?php
include_once '../../controllers/config.php';

$query = "
SELECT 
    m.movie_id AS id, 
    m.title, 
    m.duration, 
    m.release_date,
    m.is_published,
    GROUP_CONCAT(g.genre_name ORDER BY g.genre_name ASC) AS genres 
FROM 
    movies m
LEFT JOIN 
    movie_genres mg ON m.movie_id = mg.movie_id
LEFT JOIN 
    genres g ON mg.genre_id = g.genre_id
GROUP BY 
    m.movie_id
ORDER BY 
    m.release_date DESC
";

$result = $conn->query($query);

$movies = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'genres' => !empty($row['genres']) ? $row['genres'] : 'No genres available',
            'duration' => $row['duration'],
            'release_date' => $row['release_date'],
            'is_published' => $row['is_published'],
        ];
    }
}

    header('Content-Type: application/json');
echo json_encode($movies);
?>
