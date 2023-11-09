<?php
require 'vendor/autoload.php'; // Include the Composer autoload file

// Configuration
$mongoDBClient = new MongoDB\Client("mongodb://localhost:27017"); // Connect to your MongoDB server
$database = $mongoDBClient->selectDatabase('NoSQLDatabase'); // Select your database
$collection = $database->selectCollection('Reviews'); // Select your collection

// Delete all documents from the collection
$deleteResult = $collection->deleteMany([]);

// Output the result of the delete operation
echo "The number of deleted documents was: " . $deleteResult->getDeletedCount();
?>
