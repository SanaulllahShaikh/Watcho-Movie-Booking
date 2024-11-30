<?php
include_once '../controllers/config.php';
if (isset($_GET['movie_id'])) {
    $movie_id = intval($_GET['movie_id']);
    
    $query = "SELECT genre_id FROM movie_genres WHERE movie_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $linked_genres = [];
    while ($row = $result->fetch_assoc()) {
        $linked_genres[] = $row['genre_id'];
    }
    
    echo json_encode(['linked_genres' => $linked_genres]);
}
?>
