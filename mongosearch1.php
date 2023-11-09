<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php'; // Include the Composer autoload file

// Configuration
$mongoDBClient = new MongoDB\Client("mongodb://localhost:27017"); // Connect to your MongoDB server
$database = $mongoDBClient->selectDatabase('NoSQLDatabase'); // Select your database
$collection = $database->selectCollection('Reviews'); // Select your collection

// Get the count of all documents in the collection
$documentCount = $collection->countDocuments();

// If there are documents in the collection
if ($documentCount > 0) {
    // Generate a random number (index)
    $randomIndex = rand(0, $documentCount - 1);

    // Skip to the random index and get the next document
    $randomDocument = $collection->find([], ['skip' => $randomIndex, 'limit' => 1])->toArray();

    // Output the random document
    print_r($randomDocument);
} else {
    echo "No documents found in the collection.";
}
?>