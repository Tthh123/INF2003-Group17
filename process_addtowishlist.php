<?php

session_start();

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
}

// Get the user email from session
$userEmail = $_SESSION['email'];

// Get the product details from the AJAX request
$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$brand = filter_input(INPUT_POST, 'brand', FILTER_SANITIZE_STRING);
$imageSrc = $_POST['imageSrc']; // no need to sanitize as per requirement

// Get the maximum quantity for the product from the products table
$sql = "SELECT quantity FROM products WHERE name = ? AND brand = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $brand);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $maxQuantity = $row['quantity'];
}

// Check if the product with the same email is already in the cart table and the quantity in the cart is less than the maximum quantity in the products table
$sql = "SELECT * FROM wishlist WHERE email = ? AND name = ? AND brand = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $userEmail, $name, $brand);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    
    // If the same product with the same email already exists, update the quantity and subtotal value
    $row = $result->fetch_assoc();
    $quantity = $row['quantity'] + 1;
    $subtotal = $row['subtotal'] + $price;

    // If the quantity in the wishlist is less than the maximum quantity in the products table, update the cart
    if ($quantity <= $maxQuantity) {
        $sql = "UPDATE wishlist SET quantity = ?, subtotal = ? WHERE email = ? AND name = ? AND brand = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dssss", $quantity, $subtotal, $userEmail, $name, $brand);
        $stmt->execute();
    }
} else {
    // If the same product with the same email and null order_id does not exist, add it to the cart table
    $quantity = 1;
    $subtotal = $price;
    if ($quantity <= $maxQuantity) {
        $sql = "INSERT INTO wishlist (price, name, brand, quantity, subtotal, imageSrc, email) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dssidss", $price, $name, $brand, $quantity, $subtotal, $imageSrc, $userEmail);
        $stmt->execute();
    }
}

// Close database connection
$stmt->close();
mysqli_close($conn);

