<?php
include_once './config.php';


$sqlMovies = "SELECT 
                    movie_id, title, description, duration, release_date, poster_url 
                FROM movies 
                WHERE is_published = 1 AND release_date <= CURDATE()
                ORDER BY popularity_score DESC, release_date DESC 
                LIMIT 4";

$resultMovies = $conn->query($sqlMovies);

if (!$resultMovies) {
    die("Error in SQL query (movies): " . $conn->error);
}

$movies = [];

if ($resultMovies->num_rows > 0) {
    while ($movie = $resultMovies->fetch_assoc()) {
        $sqlGenres = "SELECT g.genre_name FROM genres g
                      JOIN movie_genres mg ON g.genre_id = mg.genre_id
                      WHERE mg.movie_id = " . $movie['movie_id'];

        $resultGenres = $conn->query($sqlGenres);

        if (!$resultGenres) {
            die("Error in SQL query (genres): " . $conn->error);
        }

        $genres = [];

        if ($resultGenres->num_rows > 0) {
            while ($genre = $resultGenres->fetch_assoc()) {
                $genres[] = $genre['genre_name'];
            }
        }

        $movies[] = [
            'id' => $movie['movie_id'],
            'title' => $movie['title'],
            'description' => $movie['description'],
            'duration' => $movie['duration'],
            'release_date' => date("jS M Y", strtotime($movie['release_date'])),
            'poster_url' => $movie['poster_url'],
            'genres' => implode(', ', $genres)
        ];
    }
    echo json_encode($movies);
} else {
    echo json_encode([]);
}

$conn->close();
