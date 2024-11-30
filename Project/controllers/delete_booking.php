<?php
require_once './config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['booking_id']) && is_numeric($_POST['booking_id'])) {
        $bookingId = $_POST['booking_id'];

        $seatQuery = "SELECT seat_ids FROM bookings WHERE booking_id = ?";
        if ($stmt = $conn->prepare($seatQuery)) {
            $stmt->bind_param("i", $bookingId);
            $stmt->execute();
            $stmt->bind_result($seatIdsJson);
            $stmt->fetch();
            $stmt->close();

            if ($seatIdsJson) {
                $seatIds = json_decode($seatIdsJson, true);

                if (!empty($seatIds)) {
                    $seatNumbers = implode(',', array_map('intval', $seatIds));
                    $deleteSeatsQuery = "DELETE FROM seats WHERE seat_number IN ($seatNumbers)";
                    if ($deleteSeatsStmt = $conn->prepare($deleteSeatsQuery)) {
                        $deleteSeatsStmt->execute();
                        $deleteSeatsStmt->close();
                    } else {
                        echo json_encode(["status" => "failure", "message" => "Failed to delete seats."]);
                        exit;
                    }
                }
            }
        } else {
            echo json_encode(["status" => "failure", "message" => "Booking not found."]);
            exit;
        }

        $deleteBookingQuery = "DELETE FROM bookings WHERE booking_id = ?";
        if ($stmt = $conn->prepare($deleteBookingQuery)) {
            $stmt->bind_param("i", $bookingId);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Booking cancelled successfully."]);
            } else {
                echo json_encode(["status" => "failure", "message" => "Failed to cancel the booking."]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "failure", "message" => "Error preparing delete booking query."]);
        }
    } else {
        echo json_encode(["status" => "failure", "message" => "Invalid booking ID."]);
    }
} else {
    echo json_encode(["status" => "failure", "message" => "Invalid request."]);
}

$conn->close();
