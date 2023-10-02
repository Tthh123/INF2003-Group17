<?php

session_start();

// Create a database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update quantity of the product
if (isset($_POST['update_quantity'])) {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $stmt = $conn->prepare("UPDATE products SET quantity=? WHERE name=?");
    $stmt->bind_param("is", $quantity, $name);
    $stmt->execute();
    $stmt->close();

    $_SESSION['success_message'] = "Quantity updated successfully!";
}

$stmt->close();
$conn->close();

// Redirect back to the admin page
header('Location: admin.php');
exit();
?>
