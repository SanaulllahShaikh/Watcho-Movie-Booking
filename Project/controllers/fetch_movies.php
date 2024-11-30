<?php
include_once './config.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 8;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$genre = isset($_GET['genre']) ? intval($_GET['genre']) : '';
$release_date = isset($_GET['release_date']) ? $_GET['release_date'] : '';

$searchTerm = "%" . $search . "%";

$total_movies_query = "SELECT COUNT(DISTINCT m.movie_id) AS total
                       FROM movies m
                       LEFT JOIN movie_genres mg ON m.movie_id = mg.movie_id
                       LEFT JOIN genres g ON mg.genre_id = g.genre_id
                       WHERE  m.is_published = 1 and (m.title LIKE ? OR m.description LIKE ?)";

if ($genre) {
    $total_movies_query .= " AND g.genre_id = ?";
}

if ($release_date) {
    $total_movies_query .= " AND YEAR(m.release_date) = ?";
}

$stmt = $conn->prepare($total_movies_query);
if ($genre && $release_date) {
    $stmt->bind_param('ssii', $searchTerm, $searchTerm, $genre, $release_date);
} elseif ($genre) {
    $stmt->bind_param('ssi', $searchTerm, $searchTerm, $genre);
} elseif ($release_date) {
    $stmt->bind_param('ssi', $searchTerm, $searchTerm, $release_date);
} else {
    $stmt->bind_param('ss', $searchTerm, $searchTerm);
}
$stmt->execute();
$total_movies_result = $stmt->get_result();
$total_movies = $total_movies_result->fetch_assoc()['total'];

$sql = "SELECT m.movie_id, m.title, m.description, m.duration, m.release_date, m.poster_url, m.banner_url, m.trailer_url, m.popularity_score, 
               GROUP_CONCAT(g.genre_name) AS genres
        FROM movies m
        LEFT JOIN movie_genres mg ON m.movie_id = mg.movie_id
        LEFT JOIN genres g ON mg.genre_id = g.genre_id
        WHERE m.is_published = 1 AND (m.title LIKE ? OR m.description LIKE ?)";

if ($genre) {
    $sql .= " AND g.genre_id = ?";
}

if ($release_date) {
    $sql .= " AND YEAR(m.release_date) = ?";
}

$sql .= " GROUP BY m.movie_id LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
if ($genre && $release_date) {
    $stmt->bind_param('ssiiii', $searchTerm, $searchTerm, $genre, $release_date, $limit, $offset);
} elseif ($genre) {
    $stmt->bind_param('ssiii', $searchTerm, $searchTerm, $genre, $limit, $offset);
} elseif ($release_date) {
    $stmt->bind_param('ssiii', $searchTerm, $searchTerm, $release_date, $limit, $offset);
} else {
    $stmt->bind_param('ssii', $searchTerm, $searchTerm, $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $movies = [];
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }

    $response = [
        'movies' => $movies,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => ceil($total_movies / $limit),
            'total_movies' => $total_movies
        ]
    ];
    echo json_encode($response);
} else {
    echo json_encode([
        'movies' => [],
        'pagination' => [
            'current_page' => $page,
            'total_pages' => 0,
            'total_movies' => 0
        ]
    ]);
}

$conn->close();
?>
