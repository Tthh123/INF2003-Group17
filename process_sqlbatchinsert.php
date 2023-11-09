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
    while ($result->num_rows > 0) {
        $orderId = 'Order' . rand(1, 2000000);
        $result = $conn->query("SELECT 1 FROM trackorder WHERE order_id = '$orderId'");
    }
    return $orderId;
}

// Check if the form was submitted and the recordCount is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recordCount'])) {

    $recordCount = intval($_POST['recordCount']);
    $batchSize = 10000; // Adjust the batch size if necessary
    // Prepare the data set for insertion
    $insertValues = [];
    for ($i = 0; $i < $recordCount; $i++) {
        $order_id = generateUniqueOrderId($conn);
        $name = $conn->real_escape_string(generateRandomName());
        $rating = rand(1, 5);
        $message = $conn->real_escape_string(generateRandomMessage());
        $imageFilename = $conn->real_escape_string(generateRandomFilename());
        $insertValues[] = "('$order_id', '$name', $rating, '$message', '$imageFilename')";
    }

    // Disable autocommit for better performance on insert
    $conn->autocommit(FALSE);

    // Disable foreign key checks for speed
    $conn->query("SET FOREIGN_KEY_CHECKS=0;");

    $tables = [
        'reviews' => 'No Indexes',
        'reviews1' => 'Individual Indexes',
        'reviews2' => 'Composite Index'
    ];
    $performanceResults = [];

    foreach ($tables as $table => $indexType) {
        $queryBase = "INSERT INTO $table (order_id, name, rating, message, image_filename) VALUES ";
        $startTime = microtime(true); // Start timing for the current table
        // Insert data in batches
        for ($i = 0; $i < count($insertValues); $i += $batchSize) {
            $batch = array_slice($insertValues, $i, $batchSize);
            $query = $queryBase . implode(', ', $batch);
            if (!$conn->query($query)) {
                $errorMsg = "Error in $table: " . $conn->error;
                $success = false;
                break; // Exit the loop on error
            }
        }

        // Commit the transaction for the current table
        $conn->commit();

        $endTime = microtime(true); // End timing for the current table
        $timeTaken = $endTime - $startTime; // Calculate the time taken for the current table
        // Collect performance data
        $performanceResults[$table] = [
            'timeTaken' => $timeTaken,
            'indexType' => $indexType
        ];

        if (!$success) {
            break; // If there was an error, do not continue with the next tables
        }
    }

    // Re-enable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS=1;");

    // Turn autocommit back on
    $conn->autocommit(TRUE);

    // Output the performance results
    echo "<div class='timing-results-container'>";
    foreach ($performanceResults as $tableName => $metrics) {
        echo "<div class='timing-results'>";
        echo "<p>Table: $tableName (Index Type: {$metrics['indexType']})</p>";
        echo "<p>Time Taken: " . sprintf('%.4f', $metrics['timeTaken']) . " seconds</p>";
        echo "</div>";
    }
    echo "</div>";

    // Output the final result
    if ($success) {
        echo "Inserted {$recordCount} records into each table successfully.";
    } else {
        echo "Batch insert failed: {$errorMsg}";
    }
}

// Close the database connection
$conn->close();
?>