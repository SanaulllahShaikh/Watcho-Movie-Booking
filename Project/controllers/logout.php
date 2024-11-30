<?php
session_start();
$location = '../index.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['email'])) {
    $location = '../index.php';
    $_SESSION = [];
    session_destroy();
} else {
    $location = '../views/login.php';
    $_SESSION = [];
    session_destroy();
}



header("Location: $location");
exit;
