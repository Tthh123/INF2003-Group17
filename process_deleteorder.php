<?php
session_start();

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != 'admin') {
    header('HTTP/1.0 401 Unauthorized');
    echo 'Unauthorized access';
    exit;
}

// Check if order_id is passed
if (!isset($_POST['order_id'])) {
    die("No order ID provided");
}

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_POST['order_id'];

// Prepare and bind
$stmt = $conn->prepare("DELETE FROM trackorder WHERE order_id = ?");
$stmt->bind_param("s", $order_id);

// Execute query and check if successful
if ($stmt->execute()) {
    // Delete matching records from the cart table
    $stmt2 = $conn->prepare("DELETE FROM cart WHERE order_id = ?");
    $stmt2->bind_param("s", $order_id);
    if ($stmt2->execute()) {
        echo "Order deleted successfully";
    } else {
        echo "Error deleting order: " . $conn->error;
    }
    $stmt2->close();
} else {
    echo "Error deleting order: " . $conn->error;
}

$stmt->close();
$conn->close();

?>
