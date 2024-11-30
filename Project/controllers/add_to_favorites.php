<?php
session_start();
header('Content-Type: application/json');

include_once './config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => true, 'success_type' => 'loginToFavorite', 'message' => 'Please log in to add movie in favorites.']);
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['movie_id']) || !is_numeric($_POST['movie_id'])) {
    echo json_encode(['error' => true, 'message' => 'Invalid movie ID.']);
    exit;
}

$movie_id = intval($_POST['movie_id']);

$sqlCheck = "SELECT * FROM favorites WHERE user_id = ? AND movie_id = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("ii", $user_id, $movie_id);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    $sqlDelete = "DELETE FROM favorites WHERE user_id = ? AND movie_id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("ii", $user_id, $movie_id);

    if ($stmtDelete->execute()) {
        echo json_encode(['error' => false, 'success_type' => 'removedMovieFromFavorite', 'message' => 'Movie removed from favorites successfully.']);
    } else {
        echo json_encode(['error' => true, 'message' => 'Error removing movie from favorites: ' . $conn->error]);
    }
} else {
    $sqlInsert = "INSERT INTO favorites (user_id, movie_id) VALUES (?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("ii", $user_id, $movie_id);

    if ($stmtInsert->execute()) {
        echo json_encode(['error' => false, 'success_type' => 'addedMovieToFavorite',  'message' => 'Movie added to favorites successfully.']);
    } else {
        echo json_encode(['error' => true, 'message' => 'Error adding movie to favorites: ' . $conn->error]);
    }
}

$conn->close();
