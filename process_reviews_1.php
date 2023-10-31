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
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Disable foreign key checks and indexes
    $conn->query("SET FOREIGN_KEY_CHECKS=0;");
    
    // Prepare a batch insert statement
    $stmt = $conn->prepare("INSERT INTO reviews (order_id, name, rating, message, image_filename) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $order_id, $name, $rating, $message, $imageFilename);
    
    // Loop a million times and insert data in batches of 1000
    $totalRecords = 1000000;
    $batchSize = 1000;
    for ($i = 0; $i < $totalRecords; $i++) {
        // Generate random data for one record
        $order_id = 'Order' . rand(1, 2000000);
        $name = ['John', 'Alice', 'Bob', 'Emily', 'David', 'Sarah', 'Michael', 'Olivia'][array_rand(['John', 'Alice', 'Bob', 'Emily', 'David', 'Sarah', 'Michael', 'Olivia'])];
        $rating = rand(1, 5);
        $messages = ['Great product!', 'Good service.', 'Nice experience.', 'Could be better.'];
        $message = $messages[array_rand($messages)];
        $extensions = ['jpg', 'png', 'gif', 'jpeg'];
        $imageFilename = 'image' . rand(1, 2000000) . '.' . $extensions[array_rand($extensions)];
        
        $dataToInsert[] = [$order_id, $name, $rating, $message, $imageFilename];
        
        if (count($dataToInsert) >= $batchSize || $i == $totalRecords - 1) {
            // Insert the batch
            foreach ($dataToInsert as $data) {
                list($order_id, $name, $rating, $message, $imageFilename) = $data;
                if (!$stmt->execute()) {
                    $errorMsg = "Error: " . $stmt->error;
                    $success = false;
                    break; // Exit the loop on error
                }
            }
            // Clear the data array for the next batch
            $dataToInsert = [];
        }
    }
    
    // Re-enable foreign key checks and indexes
    $conn->query("SET FOREIGN_KEY_CHECKS=1;");
    
    // Close the statement
    $stmt->close();
}

// Close the database connection
mysqli_close($conn);

// Redirect back to the form page with a success or error message
if ($success) {
    header("Location: reviewscompleted.php?success=1");
} else {
    header("Location: reviewscompleted.php?error=" . urlencode($errorMsg));
}
