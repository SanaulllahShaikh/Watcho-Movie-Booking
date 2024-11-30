<?php
session_start();
require_once './config.php';


$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$query = "SELECT movies.movie_id, movies.title, movies.description, movies.duration, movies.release_date, movies.poster_url
          FROM favorites
          JOIN movies ON favorites.movie_id = movies.movie_id
          WHERE favorites.user_id = ?";
$stmt = $conn->prepare($query);

$stmt->bind_param('i', $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $movies = [];

    while ($movie = $result->fetch_assoc()) {
        $genreQuery = "SELECT g.genre_name 
                       FROM genres g
                       JOIN movie_genres mg ON g.genre_id = mg.genre_id
                       WHERE mg.movie_id = ?";
        $genreStmt = $conn->prepare($genreQuery);
        $genreStmt->bind_param('i', $movie['movie_id']);
        $genreStmt->execute();

        $genreResult = $genreStmt->get_result();
        $genres = [];
        while ($genre = $genreResult->fetch_assoc()) {
            $genres[] = $genre['genre_name'];
        }

        $movie['genres'] = $genres;

        $movies[] = $movie;
    }

    echo json_encode([
        'success' => true,
        'data' => $movies
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No favorite movies found'
    ]);
}

$conn->close();
?>
