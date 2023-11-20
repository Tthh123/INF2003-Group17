<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php'; // Include the MongoDB PHP Library

try {
    // Create a MongoDB client and connect to the server
    $client = new MongoDB\Client("mongodb://localhost:27017");

    // Select the "Jackson" database
    $database = $client->Jackson; // Replace 'Jackson' with your database name

    // Access the "Collection1" collection
    $collection = $database->Collection1; // Replace 'Collection1' with your collection name

    // Perform operations on the $collection.
    
    // For example, you can retrieve documents from the collection:
    $cursor = $collection->find([]);

    foreach ($cursor as $document) {
        var_dump($document);
    }

} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
