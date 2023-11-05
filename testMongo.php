
<?php
#Testing of mongodb CRUD operations



require 'vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->selectDatabase('Jackson')->selectCollection('Collection1');

// Criteria to match the document you want to delete
$criteria = ['name' => 'NewPerson'];

// Perform the delete operation
$deleteResult = $collection->deleteOne($criteria);

// Output the result of the delete operation
echo "Deleted " . $deleteResult->getDeletedCount() . " document(s).";
?>
