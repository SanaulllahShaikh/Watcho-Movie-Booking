<?php
header('Content-Type: application/json');
include_once '../../controllers/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cinemaId = $_POST['cinemaId'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postalCode = $_POST['postalCode'];
    $contact = $_POST['contact'];
    $cinemaType = $_POST['cinemaType'];

    if (empty($name) || empty($address) || empty($city) || empty($state) || empty($postalCode) || empty($contact) || empty($cinemaType)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $sql = "UPDATE cinemas SET cinema_name = ?, address = ?, city = ?, state = ?, postal_code = ?, contact_number = ?, cinema_type = ? WHERE cinema_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $name, $address, $city, $state, $postalCode, $contact, $cinemaType, $cinemaId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'cinema_name' => $name]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update cinema.']);
    }

    $stmt->close();
    $conn->close();
}
