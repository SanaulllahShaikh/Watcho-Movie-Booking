<?php
require './config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['Email'] = "Please enter a valid email address.";
    }

    if (empty($password)) {
        $errors['Password'] = "Please enter your password.";
    }

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit;
    }

    $stmt = $conn->prepare("SELECT user_id, username, email, is_admin, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $user_email, $is_admin, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $user_email;
            $_SESSION['is_admin'] = $is_admin;

            $session_id = session_id();
            $insertSession = $conn->prepare("INSERT INTO sessions (session_id, user_id) VALUES (?, ?)
                                             ON DUPLICATE KEY UPDATE last_active = CURRENT_TIMESTAMP");
            $insertSession->bind_param("si", $session_id, $user_id);
            $insertSession->execute();
            $insertSession->close();

            echo json_encode(['status' => 'success', 'message' => 'Login successful!', 'is_admin' => (bool)$is_admin]);
        } else {
            echo json_encode(['status' => 'error', 'errors' => ['general' => 'Incorrect email or password.']]);
        }
    } else {
        echo json_encode(['status' => 'error', 'errors' => ['general' => 'Incorrect email or password.']]);
    }

    $stmt->close();
    $conn->close();
}
?>
