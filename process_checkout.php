<?php

session_start();

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Get the user email from session and sanitize it
$userEmail = mysqli_real_escape_string($conn, $_SESSION['email']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if order ID is null for any cart
$sql = "SELECT * FROM cart WHERE email = '$userEmail' AND order_id IS NULL";
$result = $conn->query($sql);

// If order ID is null, set all order ID to be the same
if ($result->num_rows > 0) {

    // Update products table
    $sql = "UPDATE products 
        INNER JOIN cart 
        ON products.name = cart.name 
        SET products.quantity = products.quantity - cart.quantity 
        WHERE cart.order_id IS NULL 
        AND cart.email = '$userEmail'";

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error updating product quantities: " . $conn->error;
    }


    // Generate a new order ID
    $order_id = "ORDER" . time() . mt_rand(100000, 999999);
    $_SESSION['order_id'] = $order_id;

    // Update cart table with new order ID
    $sql = "UPDATE cart SET order_id = '$order_id' WHERE email = '$userEmail' AND order_id IS NULL";
    if ($conn->query($sql) === TRUE) {

        // Generate a new unique delivery ID
        $delivery_id = mt_rand(100000000, 999999999);
        $sql = "SELECT COUNT(*) AS count FROM trackorder WHERE deliveryid = '$delivery_id'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];

        // If delivery ID is not unique, generate a new one
        while ($count > 0) {
            $delivery_id = mt_rand(100000000, 999999999);
            $sql = "SELECT COUNT(*) AS count FROM trackorder WHERE deliveryid = '$delivery_id'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $count = $row['count'];
        }

        // Get the ship date (1 week from now)
        $ship_date = date('Y-m-d', strtotime('+1 week'));

        // Generate a random order status
        $order_status = array('orderprocessed', 'ordershipped', 'orderenroute');
        $status_key = array_rand($order_status);
        $status = $order_status[$status_key];

        // Insert data into trackorder table
        $sql = "INSERT INTO trackorder (order_id, deliveryid, ship_date, order_status, fname, lname, city, email, deliveryaddress)
    SELECT order_id, '$delivery_id', '$ship_date', '$status', fname, lname, city, email, homeaddress FROM cart WHERE email = '$userEmail' AND order_id = '$order_id' LIMIT 1";
        if ($conn->query($sql) === TRUE) {
            
        } else {
            echo "Error inserting data into trackorder table: " . $conn->error;
        }

        // Output the generated order_id
        echo $order_id;
    } else {
        echo "Error updating order IDs: " . $conn->error;
    }
}

// Close MySQL connection
$conn->close();

