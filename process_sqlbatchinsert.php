<?php

// Initialize variables for error handling
$success = true;
$errorMsg = '';

// Increase the maximum execution time for this script
set_time_limit(300); // 300 seconds = 5 minutes
// Increase the memory limit for this script
ini_set('memory_limit', '256M');

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a random string
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}

// Function to generate random names
function generateRandomName() {
    $names = ['John', 'Alice', 'Bob', 'Emily', 'David', 'Sarah', 'Michael', 'Olivia'];
    return $names[array_rand($names)];
}

// Function to generate random messages
function generateRandomMessage() {
    $messages = [
        'Great product!',
        'Good quality, would buy again.',
        'Satisfied with the purchase.',
        'Could be better.',
        'Not what I expected.',
        'Fantastic service and product!',
        'Love it!',
        'The product arrived on time and met my expectations.'
    ];
    return $messages[array_rand($messages)];
}

// Function to generate random filenames
function generateRandomFilename() {
    $extensions = ['jpg', 'png', 'gif', 'jpeg'];
    return 'image' . rand(1, 2000000) . '.' . $extensions[array_rand($extensions)];
}

// Function to generate unique order_id
function generateUniqueOrderId($conn) {
    $orderId = 'Order' . rand(1, 2000000);
    // Check if order ID already exists in the database
    $result = $conn->query("SELECT 1 FROM trackorder WHERE order_id = '$orderId'");
    while($result->num_rows > 0) {
        $orderId = 'Order' . rand(1, 2000000);
        $result = $conn->query("SELECT 1 FROM trackorder WHERE order_id = '$orderId'");
    }
    return $orderId;
}

// Check if the form was submitted and the recordCount is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recordCount'])) {

    $recordCount = intval($_POST['recordCount']);
    $batchSize = 10000; // Adjust the batch size if necessary
    
    // Disable foreign key checks for speed
    $conn->query("SET FOREIGN_KEY_CHECKS=0;");
    $conn->autocommit(FALSE); // Turn off autocommit for better performance on insert

    $startTime = microtime(true); // Start timing
    
    $insertValues = []; // Array to hold all rows for batch insert
    $queryBase = "INSERT INTO reviews (order_id, name, rating, message, image_filename) VALUES ";

    // Generate all insert values up front
    for ($i = 0; $i < $recordCount; $i++) {
        $order_id = generateUniqueOrderId($conn);
        $name = $conn->real_escape_string(generateRandomName());
        $rating = rand(1, 5);
        $message = $conn->real_escape_string(generateRandomMessage()); // Use the generateRandomMessage function
        $imageFilename = $conn->real_escape_string(generateRandomFilename());

        $insertValues[] = "('$order_id', '$name', $rating, '$message', '$imageFilename')";
        
        // Execute the batch insert when the batch size is reached or it's the last record
        if (count($insertValues) >= $batchSize || $i == $recordCount - 1) {
            $query = $queryBase . implode(', ', $insertValues);
            if (!$conn->query($query)) {
                $errorMsg = "Error: " . $conn->error;
                $success = false;
                break; // Exit the loop on error
            }
            $insertValues = []; // Reset array for the next batch
        }
    }
    
    // Commit the transaction
    $conn->commit();

    // Re-enable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS=1;");
    $endTime = microtime(true); // End timing
    $timeTaken = $endTime - $startTime; // Calculate the time taken

    // Turn autocommit back on
    $conn->autocommit(TRUE);
    // Output the result
    if ($success) {
        echo "Inserted {$recordCount} records successfully in {$timeTaken} seconds.";
    } else {
        echo "Batch insert failed: {$errorMsg}";
    }
}

// Close the database connection
$conn->close();

?>
