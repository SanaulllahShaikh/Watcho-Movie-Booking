<?php
include_once '../../controllers/config.php';

$response = [];

if (!isset($_POST['genre_name']) || empty(trim($_POST['genre_name']))) {
    $response['success'] = false;
    $response['error'] = "Genre name is required.";
    echo json_encode($response);
    exit();
}

$genre_names = explode(" ", trim($_POST['genre_name']));
$genre_names = array_filter($genre_names, fn($name) => !empty(trim($name)));

if (empty($genre_names)) {
    $response['success'] = false;
    $response['error'] = "No valid genres provided.";
    echo json_encode($response);
    exit();
}

if (!$conn) {
    $response['success'] = false;
    $response['error'] = "Database connection failed.";
    echo json_encode($response);
    exit();
}

$checkStmt = $conn->prepare("SELECT COUNT(*) FROM genres WHERE genre_name = ?");
$checkStmt->bind_param("s", $genre_name);

$stmt = $conn->prepare("INSERT INTO genres (genre_name) VALUES (?)");
$stmt->bind_param("s", $genre_name);

$inserted = 0;
$existing = 0;

foreach ($genre_names as $name) {
    $genre_name = ucfirst(strtolower(trim($name)));

    if (!empty($genre_name)) {
        $checkStmt->execute();
        
        $checkStmt->store_result(); 
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        
        if ($count > 0) {
            $existing++;
        } else {
            if ($stmt->execute()) {
                $inserted++;
            } else {
                $response['success'] = false;
                $response['error'] = "Failed to insert genre: " . $stmt->error;
                echo json_encode($response);
                exit();
            }
        }

        $checkStmt->free_result();
    }
}

$checkStmt->close();
$stmt->close();
$conn->close();

if ($inserted > 0) {
    $response['success'] = true;
    $response['message'] = "$inserted genres added successfully!";
}

if ($existing > 0) {
    $response['success'] = false;
    $response['error'] = "$existing genre(s) already exist and were not added.";
}

if ($inserted == 0 && $existing == 0) {
    $response['success'] = false;
    $response['error'] = "No genres were added. Please try again.";
}

header('Content-Type: application/json');
echo json_encode($response);
