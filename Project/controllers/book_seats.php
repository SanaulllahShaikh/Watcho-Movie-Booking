<?php
include_once("./config.php");
session_start();

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cinema_id = $_POST['cinema_id'];
    $screen_id = $_POST['screen_id'];
    $show_id = $_POST['show_id'];
    $selected_seats = $_POST['selected_seats'];
    $user_id = $_SESSION['user_id'];
    $payment_method = 'Credit Card';

    if (empty($selected_seats)) {
        $response = [
            "status" => "error",
            "message" => "No seats selected."
        ];
        echo json_encode($response);
        exit;
    }

    $price_query = "SELECT price FROM shows WHERE show_id = ?";
    $price_stmt = $conn->prepare($price_query);
    $price_stmt->bind_param("i", $show_id);
    $price_stmt->execute();
    $price_result = $price_stmt->get_result();

    if ($price_result->num_rows > 0) {
        $show_data = $price_result->fetch_assoc();
        $seat_price = $show_data['price'];
    } else {
        $response = [
            "status" => "error",
            "message" => "Invalid show ID."
        ];
        echo json_encode($response);
        exit;
    }

    foreach ($selected_seats as $seat) {
        $seat_number = $seat['seat'];
        $seat_type = $seat['type'];

        $price = $seat_type === 'VIP' ? $seat_price * 2 : $seat_price;

        $insert_query = "INSERT INTO seats (screen_id, show_id, seat_number, seat_type, price, status) 
                         VALUES (?, ?, ?, ?, ?, 'Reserved')";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iissd", $screen_id, $show_id, $seat_number, $seat_type, $price);
        $insert_stmt->execute();
    }

    $total_price = 0;
    foreach ($selected_seats as $seat) {
        $seat_type = $seat['type'];
        $price = $seat_type === 'VIP' ? $seat_price * 2 : $seat_price;
        $total_price += $price;
    }

    $seat_ids_json = json_encode($selected_seats);

    $booking_query = "INSERT INTO bookings (user_id, show_id, seat_ids, total_price, status, payment_method) 
                      VALUES (?, ?, ?, ?, 'Pending', ?)";
    $booking_stmt = $conn->prepare($booking_query);
    $booking_stmt->bind_param("iissd", $user_id, $show_id, $seat_ids_json, $total_price, $payment_method);
    $booking_stmt->execute();

    if ($booking_stmt->affected_rows > 0) {
        $booking_id = $conn->insert_id;

        $response = [
            "status" => "success",
            "message" => "Booking created successfully!",
            "data" => [
                "booking_id" => $booking_id,
                "user_id" => $user_id,
                "show_id" => $show_id,
                "selected_seats" => $selected_seats,
                "total_price" => $total_price,
                "payment_method" => $payment_method
            ]
        ];
    } else {
        $response = [
            "status" => "error",
            "message" => "Failed to create booking."
        ];
    }
}

echo json_encode($response);
