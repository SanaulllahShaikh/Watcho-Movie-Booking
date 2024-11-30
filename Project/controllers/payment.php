<?php
include('./config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $card_number = $_POST['card_number'];
    $email = $_POST['email'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $billing_address = $_POST['billing_address'];
    $booking_id = $_POST['booking_id'];

    $sql = "UPDATE bookings SET status = 'Confirmed', payment_method = 'Credit Card' WHERE booking_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $booking_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Payment confirmed and booking updated."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update booking status."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error preparing the query."]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
