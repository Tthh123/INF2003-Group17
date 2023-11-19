<?php

require 'vendor/autoload.php'; // Include the Composer autoload file
// Configuration
$mongoDBClient = new MongoDB\Client("mongodb://localhost:27017"); // Connect to your MongoDB server
$database = $mongoDBClient->selectDatabase('NoSQLDatabase'); // Select your database
// Open the CSV file
if (($handle = fopen("NoSQL_1K.csv", "r")) !== FALSE) {
    // Read the first line as headers
    $headerLine = fgets($handle);
    // Remove the double quotes and newline, then split by semicolon
    $header = str_getcsv(trim($headerLine, "\"\n\r"), ';');

    $reviewsData = [];

    // Read each line of the CSV file and convert it to an associative array
    while (($rowData = fgets($handle)) !== FALSE) {
        // Remove the double quotes and newline, then split by semicolon
        $row = str_getcsv(trim($rowData, "\"\n\r"), ';');
        // Combine header and row to an associative array if they match in count
        if (count($header) == count($row)) {
            $reviewsData[] = array_combine($header, $row);
        }
    }
    fclose($handle); // Close the CSV file
    if (empty($reviewsData)) {
        die("No data to insert");
    }

    $collections = $database->listCollections();

    foreach ($collections as $collectionInfo) {
        $collectionName = $collectionInfo->getName();
        $collection = $database->selectCollection($collectionName);
        $startTime = microtime(true);

        // Batch insert into MongoDB
        try {
            $insertManyResult = $collection->insertMany($reviewsData);
            echo "Inserted " . $insertManyResult->getInsertedCount() . " documents\n";
        } catch (MongoDB\Driver\Exception\Exception $e) {
            echo "An error occurred: " . $e->getMessage() . "\n";
        }

        // End timing
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        echo "Insertion took " . $executionTime . " seconds.\n";
    }

    // Start timing
}
?>
