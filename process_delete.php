<?php

session_start();

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete Product
$productname = mysqli_real_escape_string($conn, $_POST['name']);

// Prepare the statements
$stmt = $conn->prepare("DELETE FROM products WHERE name = ?");
$stmt_cart = $conn->prepare("DELETE FROM cart WHERE name = ? AND order_id IS NULL");
$stmt_wishlist = $conn->prepare("DELETE FROM wishlist WHERE name = ?");

// Bind the parameters
$stmt->bind_param("s", $productname);
$stmt_cart->bind_param("s", $productname);
$stmt_wishlist->bind_param("s", $productname);

// Execute the statements
$delete_product = $stmt->execute();
$delete_cart = $stmt_cart->execute();
$delete_wishlist = $stmt_wishlist->execute();

if ($delete_product) {
    $_SESSION['product_deleted'] = true;
    $success = true;
    header("Location: admin.php");
    exit();
} else {
    $_SESSION['product_deleted'] = false;
    $success = false;
    header("Location: admin.php");
    exit();
}

// Close the statements
$stmt->close();
$stmt_cart->close();
$stmt_wishlist->close();
