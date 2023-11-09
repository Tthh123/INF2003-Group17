<?php

// Initialize variables for error handling
$success = true;
$errorMsg = '';

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
} else {
    // Turn off autocommit for better performance on insert
    $conn->autocommit(FALSE);
}

// Check if the form was submitted and the recordCount is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recordCount'])) {
    
    $recordCount = intval($_POST['recordCount']);
    
    // Disable foreign key checks for speed
    $conn->query("SET FOREIGN_KEY_CHECKS=0;");

    $values = [];
    $placeholders = []; // Array to hold (?, ?, ?, ?, ?) placeholders
    $startTime = microtime(true); // Start timing

    // Loop through the number of records to be inserted
    for ($i = 0; $i < $recordCount; $i++) {
        // Generate random data for one record
        $order_id = 'Order' . rand(1, 2000000);
        $name = 'John'; // Example name
        $rating = rand(1, 5);
        $message = 'Great product!';
        $imageFilename = 'image.jpg';

        // Create placeholders and values array
        $placeholders[] = "(?, ?, ?, ?, ?)";
        array_push($values, $order_id, $name, $rating, $message, $imageFilename);
    }

    // Prepare a multi-insert statement
    $sql = "INSERT INTO reviews (order_id, name, rating, message, image_filename) VALUES " . implode(', ', $placeholders);
    $stmt = $conn->prepare($sql);

    // Bind the values dynamically
    $types = str_repeat('ssiss', $recordCount); // Types for binding, s = string, i = integer
    $stmt->bind_param($types, ...$values);

    // Execute the insert and check for errors
    if (!$stmt->execute()) {
        $errorMsg = "Error: " . $stmt->error;
        $success = false;
    }

    // Commit the changes
    if ($success) {
        $conn->commit();
    } else {
        $conn->rollback();
    }

    // Re-enable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS=1;");

    // Calculate the time taken
    $endTime = microtime(true);
    $timeTaken = $endTime - $startTime;

    // Close the statement
    $stmt->close();

    // Output the result
    if ($success) {
        echo "Inserted {$recordCount} records successfully in {$timeTaken} seconds.";
    } else {
        echo "Batch insert failed: {$errorMsg}";
    }
}

// Restore autocommit and close the database connection
$conn->autocommit(TRUE);
$conn->close();

?>
