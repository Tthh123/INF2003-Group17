<?php

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
}

// Validate user input
if (!isset($_POST['name']) || empty($_POST['name'])) {
    echo "Name is required";
    exit;
}
$name = mysqli_real_escape_string($conn, $_POST['name']);

// Execute DELETE query
$sql = "DELETE FROM wishlist WHERE name = '$name'";
$result = mysqli_query($conn, $sql);

// Refresh the current page
header("Refresh:0");

// Check if query was successful
if ($result) {
    echo 'Row deleted successfully';
} else {
    echo 'Error deleting row: ' . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
