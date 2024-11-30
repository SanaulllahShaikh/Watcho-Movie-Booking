<?php
include_once '../../controllers/config.php';

$response = [];

if (isset($_POST['movie_id']) && !empty($_POST['movie_id']) && isset($_POST['genre_ids']) && !empty($_POST['genre_ids'])) {
    $movie_id = intval($_POST['movie_id']);
    $genre_ids = $_POST['genre_ids'];

    // Check if the movie exists
    $movie_check_query = "SELECT movie_id FROM movies WHERE movie_id = ?";
    $stmt = $conn->prepare($movie_check_query);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Fetch already linked genres for the movie
        $linked_genres_query = "SELECT genre_id FROM movie_genres WHERE movie_id = ?";
        $linked_stmt = $conn->prepare($linked_genres_query);
        $linked_stmt->bind_param("i", $movie_id);
        $linked_stmt->execute();
        $linked_result = $linked_stmt->get_result();

        $existing_genres = [];
        while ($row = $linked_result->fetch_assoc()) {
            $existing_genres[] = $row['genre_id'];
        }

        // Separate new genres and already linked genres
        $new_genres = [];
        $already_linked = [];

        foreach ($genre_ids as $genre_id) {
            if (in_array($genre_id, $existing_genres)) {
                $already_linked[] = $genre_id;
            } else {
                $new_genres[] = $genre_id;
            }
        }

        // Insert only new genres
        if (!empty($new_genres)) {
            $insert_query = "INSERT INTO movie_genres (movie_id, genre_id) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_query);

            foreach ($new_genres as $genre_id) {
                $insert_stmt->bind_param("ii", $movie_id, $genre_id);
                $insert_stmt->execute();
            }
        }

        $response['success'] = true;
        $response['message'] = "Genres successfully linked to the movie!";
        $response['already_linked'] = count($already_linked);
        $response['newly_added'] = count($new_genres);
    } else {
        $response['success'] = false;
        $response['error'] = "Movie not found.";
    }
} else {
    $response['success'] = false;
    $response['error'] = "Please select both a movie and genre(s).";
}

header('Content-Type: application/json');
echo json_encode($response);
