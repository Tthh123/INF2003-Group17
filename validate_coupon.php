<?php

session_start();

// Create a database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $_SESSION['error_message'] = $errorMsg;
    // Redirect to cart.php
    header('Location: cart.php');
    exit();
}

// Get the coupon code from the form input
$coupon_code = $_POST['coupon_code'] ?? '';

// Sanitize user input
$coupon_code = filter_var($coupon_code, FILTER_SANITIZE_STRING);

// Assign the sanitized coupon code to a session variable
$_SESSION['coupon_code'] = $coupon_code;

// Retrieve the coupon data from the database
$sql = "SELECT percentage FROM couponcode WHERE couponcodename = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    $errorMsg = "Error preparing the statement: " . $conn->error;
    exit();
}

$stmt->bind_param("s", $coupon_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $discount_percentage = $row['percentage'];

    // Get the total from the session and calculate the discounted total
    $total = $_SESSION['total'];
    $discounted_total = $total * (1 - $discount_percentage / 100);

    // Update the session variable total
    $_SESSION['newtotal'] = $discounted_total;

    // Set the success message
    $_SESSION['success_message'] = 'Coupon code applied successfully!';

    // Redirect to cart.php
    header('Location: cart.php');
    exit();
} else {
    $_SESSION['error_message'] = "Invalid coupon code";

    // Redirect to cart.php
    header('Location: cart.php');
    exit();
}

$conn->close();
?>