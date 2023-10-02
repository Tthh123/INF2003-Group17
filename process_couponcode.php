<?php

// Check if the user is an admin and redirect to login page if not
session_start();
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Create database connection.
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
}

function sanitize_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Check connection
if ($conn->connect_error) {
    $_SESSION['error_message'] = "Connection failed: " . $conn->connect_error;
    header('Location: faillogin.php');
    exit;
}

// Check for duplicate coupon name
if (isset($_POST['coupon_name'])) {
    $coupon_name = sanitize_input($_POST['coupon_name']);
    $stmt = $conn->prepare("SELECT couponcodename FROM couponcode WHERE couponcodename = ?");
    $stmt->bind_param("s", $coupon_name);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // Coupon name already exists
        $_SESSION['error_message'] = "Coupon name already exists";
        header('Location: admin.php');
        exit;
    }
    $stmt->close();
}

// Insert Coupon
if (isset($_POST['coupon_name']) && isset($_POST['coupon_percentage'])) {
    $coupon_name = sanitize_input($_POST['coupon_name']);
    $coupon_percentage = sanitize_input($_POST['coupon_percentage']);
    $stmt = $conn->prepare("INSERT INTO couponcode (couponcodename, percentage) VALUES (?, ?)");
    $stmt->bind_param("si", $coupon_name, $coupon_percentage);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Coupon created successfully!";
        $success = true;
    } else {
        $_SESSION['error_message'] = "Error inserting coupon: " . $conn->error;
        header('Location: admin.php');
        exit;
    }
    $stmt->close();
}


if (!$success) {
    header('Location: admin.php');
    exit;
} else {
    header('Location: admin.php');
    exit;
}

