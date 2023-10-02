<?php
// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database for the total number of orders
$sql = "SELECT COUNT(DISTINCT order_id) AS num_orders FROM cart";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$num_orders = $row['num_orders'];

// Query the database for the sum of the total column
$sql = "SELECT SUM(total) AS total_sum FROM (SELECT DISTINCT order_id, total FROM cart) AS subquery;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_sum = number_format($row['total_sum'], 2);

// Close the connection
mysqli_close($conn);
