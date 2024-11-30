<?php
require './config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['user_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $errors = [];

    // Validate input fields
    if (strlen($username) < 5) {
        $errors['username'] = "Username must be at least 5 characters long.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Enter a valid email address.";
    }

    if (strlen($password) < 5) {
        $errors['password'] = "Password must be at least 5 characters long";
    }

    if ($password !== $password_confirmation) {
        $errors['passwordConfirmation'] = "Passwords do not match.";
    }

    if ($dob) {
        $birthDate = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;

        if ($age < 1 || $age > 100) {
            $errors['dob'] = "Please enter a valid age (1-100 years old).";
        }
    } else {
        $errors['dob'] = "Please enter your birth date.";
    }

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit;
    }

    $checkStmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $resultCheck = $checkStmt->get_result();

    if ($resultCheck->num_rows > 0) {
        echo json_encode(['status' => 'errorExist', 'emailExist' => 'Account already exists with this email.']);
        $checkStmt->close();
        $conn->close();
        exit;
    }

    $checkUsernameStmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $checkUsernameStmt->bind_param("s", $username);
    $checkUsernameStmt->execute();
    $resultUsernameCheck = $checkUsernameStmt->get_result();

    if ($resultUsernameCheck->num_rows > 0) {
        echo json_encode(['status' => 'errorUsername', 'usernameExist' => 'Username is already taken.']);
        $checkUsernameStmt->close();
        $conn->close();
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, age) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $email, $hashed_password, $age);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
    } else {
        echo json_encode(['status' => 'errorFail', 'registerFail' => "Registration failed. Please try again."]);
    }

    $checkStmt->close();
    $checkUsernameStmt->close();
    $stmt->close();
    $conn->close();
}
