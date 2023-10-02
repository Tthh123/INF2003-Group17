<?php
session_start();

// Get the coupon code name from the form input
if (isset($_POST['delete_coupon']) && isset($_POST['couponcodename'])) {
    $couponcodename = $_POST['couponcodename'];

    // Create a database connection
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the coupon from the database
    $sql = "DELETE FROM couponcode WHERE couponcodename = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $couponcodename);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['success_message'] = "Coupon code deleted successfully!";
    } else {
        $_SESSION['error_message'] = "Error deleting coupon code: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the admin page
    header('Location: admin.php');
    exit();
}
?>
