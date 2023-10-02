<?php
session_start();
// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive and decode the JSON data
$postData = json_decode(file_get_contents('php://input'), true);

$orderId = $postData['orderId'];
$updatedStatus = $postData['updatedStatus'];

error_log("Updated status: " . $updatedStatus); // Use error_log instead of alert
error_log("Order ID: " . $orderId); // Use error_log instead of alert

// Update the order status in the database
$sql = "UPDATE trackorder SET order_status = ? WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $updatedStatus, $orderId);
$stmt->execute();

// Close the connection
$stmt->close();
$conn->close();

// Return the updated status as JSON
header('Content-Type: application/json');
echo json_encode($updatedStatus);
?>
