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
if (!empty($_POST['name'])) {
    // Sanitize user input
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // Execute DELETE query
    $sql = "DELETE FROM cart WHERE name = '$name'";
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($result) {
        echo "<script>alert('Row deleted successfully')</script>";
    } else {
        echo "<script>alert('Error deleting row: " . mysqli_error($conn) . "')</script>";
    }
} else {
    echo "<script>alert('Error: Name parameter is empty.')</script>";
}

// Refresh the current page
header("Refresh:0");

// Close database connection
mysqli_close($conn);
