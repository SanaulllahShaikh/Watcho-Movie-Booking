<?php
include_once '../../controllers/config.php';

$response = array('status' => 'error', 'message' => 'An error occurred.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $movie_id = isset($_POST['movie_id']) ? trim($_POST['movie_id']) : '';
    $movie_title = isset($_POST['movie_title']) ? trim($_POST['movie_title']) : '';
    $movie_description = isset($_POST['movie_description']) ? trim($_POST['movie_description']) : '';
    $release_date = isset($_POST['release_date']) ? trim($_POST['release_date']) : '';
    $movie_genre = isset($_POST['movie_genre']) ? trim($_POST['movie_genre']) : '';
    $movie_duration = isset($_POST['movie_duration']) ? trim($_POST['movie_duration']) : '';
    $is_published = isset($_POST['publish']) ? $_POST['publish'] : 0;  // Get the publish status (1 or 0)

    if (empty($movie_id) || empty($movie_title) || empty($movie_description) || empty($movie_genre) || empty($movie_duration)) {
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit();
    } else {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $release_date)) {
            $response['message'] = 'Invalid date format. Please enter release date as YYYY-MM-DD.';
            echo json_encode($response);
            exit();
        }

        // Check if the movie already exists
        $query = "SELECT * FROM movies WHERE movie_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $movie_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $movie = $result->fetch_assoc();

        if (!$movie) {
            $response['message'] = 'Movie not found.';
            echo json_encode($response);
            exit();
        }

        // Check if poster, trailer, or banner files are being updated
        $poster_path = $movie['poster_url'];  // Keep the old poster by default
        if (isset($_FILES['movie_poster']) && $_FILES['movie_poster']['error'] == 0) {
            $poster_tmp_name = $_FILES['movie_poster']['tmp_name'];
            $poster_name = $_FILES['movie_poster']['name'];
            $poster_ext = pathinfo($poster_name, PATHINFO_EXTENSION);
            $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
            if (!in_array(strtolower($poster_ext), $allowed_ext)) {
                $response['message'] = 'Poster file type is not allowed. Allowed types: jpg, jpeg, png, gif.';
                echo json_encode($response);
                exit();
            } else {
                $poster_path_last = uniqid() . '.' . $poster_ext;
                $poster_path = '../../views/uploads/images/' . $poster_path_last;
                move_uploaded_file($poster_tmp_name, $poster_path);
                $poster_path = '/uploads/images/' . $poster_path_last;
            }
        }

        $trailer_path = $movie['trailer_url']; // Keep the old trailer by default
        if (isset($_FILES['upload_trailer']) && $_FILES['upload_trailer']['error'] == 0) {
            $trailer_tmp_name = $_FILES['upload_trailer']['tmp_name'];
            $trailer_name = $_FILES['upload_trailer']['name'];
            $trailer_ext = pathinfo($trailer_name, PATHINFO_EXTENSION);
            $allowed_video_ext = array('mp4', 'mov', 'avi');
            if (!in_array(strtolower($trailer_ext), $allowed_video_ext)) {
                $response['message'] = 'Trailer file type is not allowed. Allowed types: mp4, mov, avi.';
                echo json_encode($response);
                exit();
            } else {
                $trailer_path_last = uniqid() . '.' . $trailer_ext;
                $trailer_path = '../../views/uploads/videos/' . $trailer_path_last;
                move_uploaded_file($trailer_tmp_name, $trailer_path);
                $trailer_path = '/uploads/videos/' . $trailer_path_last;
            }
        }

        $banner_path = $movie['banner_url'];
        if (isset($_FILES['upload_banner']) && $_FILES['upload_banner']['error'] == 0) {
            $banner_tmp_name = $_FILES['upload_banner']['tmp_name'];
            $banner_name = $_FILES['upload_banner']['name'];
            $banner_ext = pathinfo($banner_name, PATHINFO_EXTENSION);
            if (!in_array(strtolower($banner_ext), $allowed_ext)) {
                $response['message'] = 'Banner file type is not allowed. Allowed types: jpg, jpeg, png, gif.';
                echo json_encode($response);
                exit();
            } else {
                $banner_path_last = uniqid() . '.' . $banner_ext;
                $banner_path = '../../views/uploads/images/' . $banner_path_last;
                move_uploaded_file($banner_tmp_name, $banner_path);
                $banner_path = '/uploads/images/' . $banner_path_last;
            }
        }

        // Movie genres handling
        $movie_genres = explode(',', $movie_genre);
        $movie_genres = array_map('trim', $movie_genres);
        $genre_ids = [];

        foreach ($movie_genres as $genre_name) {
            $query = "SELECT genre_id FROM genres WHERE genre_name = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $genre_name);
            $stmt->execute();
            $result = $stmt->get_result();
            $genre = $result->fetch_assoc();
            if ($genre) {
                $genre_ids[] = $genre['genre_id'];
            }
            $stmt->close();
        }

        // Update movie record with publish status
        $query = "UPDATE movies SET title = ?, description = ?, release_date = ?, duration = ?, poster_url = ?, trailer_url = ?, banner_url = ?, is_published = ? WHERE movie_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssssi", $movie_title, $movie_description, $release_date, $movie_duration, $poster_path, $trailer_path, $banner_path, $is_published, $movie_id);
        $stmt->execute();

        // Delete existing movie genres before inserting new ones
        $delete_genres_query = "DELETE FROM movie_genres WHERE movie_id = ?";
        $stmt = $conn->prepare($delete_genres_query);
        $stmt->bind_param("i", $movie_id);
        $stmt->execute();

        // Insert new genres
        foreach ($genre_ids as $genre_id) {
            $insert_movie_genre = "INSERT INTO movie_genres (movie_id, genre_id) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_movie_genre);
            $stmt->bind_param("ii", $movie_id, $genre_id);
            $stmt->execute();
        }

        $response['status'] = 'success';
        $response['message'] = 'Movie updated successfully!';
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No form method data found.']);
    exit();
}

echo json_encode($response);
