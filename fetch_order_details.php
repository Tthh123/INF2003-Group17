<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $orderId = $data['orderId'];

    // Create database connection
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query the database for order details
    $sql = "SELECT name, quantity, subtotal, total, couponname, homeaddress, fname, lname, zip, email FROM cart WHERE order_id = '$orderId'";
    $result = mysqli_query($conn, $sql);
    
    $orderDetails = [];
    $total = null;
    $couponname = null;
    $homeAddress = null;
    $firstName = null;
    $lastName = null;
    $zipCode = null;
    $email = null;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orderDetails[] = [
                'name' => $row['name'],
                'quantity' => $row['quantity'],
                'subtotal' => $row['subtotal']
            ];

            // Set the total and couponname fields
            $total = $row['total'];
            $couponname = $row['couponname'];
            $homeAddress = $row['homeaddress'];
            $firstName = $row['fname'];
            $lastName = $row['lname'];
            $zipCode = $row['zip'];
            $email = $row['email'];
        }
    }

    // Close the connection
    mysqli_close($conn);

    // Return the order details as JSON
    echo json_encode([
        'orderDetails' => $orderDetails,
        'total' => $total,
        'couponname' => $couponname,
        'homeAddress' => $homeAddress,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'zipCode' => $zipCode,
        'email' => $email
    ]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
