<?php
include_once '../../controllers/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cinema_name = $_POST['cinema_name'];
    $cinema_address = $_POST['cinema_address'];
    $cinema_city = $_POST['cinema_city'];
    $cinema_state = $_POST['cinema_state'];
    $cinema_postal_code = $_POST['cinema_postal_code'];
    $cinema_contact_number = $_POST['cinema_contact_number'];
    $cinema_type = $_POST['cinema_type'];

    if (empty($cinema_name) || empty($cinema_address) || empty($cinema_city) || empty($cinema_state) || empty($cinema_postal_code) || empty($cinema_contact_number) || empty($cinema_type)) {
        echo 'Please fill in all the required fields.';
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO cinemas (cinema_name, address, city, state, postal_code, contact_number, cinema_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $cinema_name, $cinema_address, $cinema_city, $cinema_state, $cinema_postal_code, $cinema_contact_number, $cinema_type);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'failed';
    }

    $stmt->close();
    $conn->close();
}
