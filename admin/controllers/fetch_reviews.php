<?php
include('../../controllers/config.php'); 

$query = "SELECT reviews.review_id, reviews.user_id, reviews.movie_id, reviews.rating, reviews.review_text, reviews.review_date, movies.title AS movie_title
          FROM reviews
          JOIN movies ON reviews.movie_id = movies.movie_id
          ORDER BY reviews.review_date DESC";

$result = $conn->query($query);

$reviews = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = [
            'review_id' => $row['review_id'],
            'user_id' => $row['user_id'],
            'movie_id' => $row['movie_id'],
            'movie_title' => $row['movie_title'],
            'rating' => $row['rating'],
            'review_text' => $row['review_text'],
            'review_date' => $row['review_date']
        ];
    }
}

echo json_encode($reviews);

$conn->close();
?>
