<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Reviews">
        <title>Reviews</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            .review-image {
                max-width: 100px;
                height: auto;
            }
            .review {
                border: 1px solid #dee2e6;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 10px;
            }
            .timing-info {
                margin-top: 10px;
                font-style: italic;
            }
            .timing-results {
                border: 1px solid #dee2e6;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 10px;
                background-color: #f8f9fa;
            }
        </style>
    </head>
    <body>

        <div class="container mt-5">
            <h1 class="text-center">Single Search Performance Analysis</h1>

            <form action="" method="get" class="mb-4">
                <div class="form-group">
                    <label for="orderIdSearch">Search by Order ID:</label>
                    <input type="text" class="form-control" id="orderIdSearch" name="orderIdSearch" placeholder="Enter Order ID">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <?php
            require 'vendor/autoload.php'; // Include the Composer autoload file

            $mongoDBClient = new MongoDB\Client("mongodb://localhost:27017");
            $database = $mongoDBClient->selectDatabase('NoSQLDatabase');
            $collections = $database->listCollections();

            if (isset($_GET['orderIdSearch']) && $_GET['orderIdSearch'] != '') {
                foreach ($collections as $collectionInfo) {
                    $collectionName = $collectionInfo->getName();
                    $collection = $database->selectCollection($collectionName);
                    $orderIdSearch = $_GET['orderIdSearch'];

                    // Start timing
                    $startTime = microtime(true);

                    // Perform the search
                    $result = $collection->find(['order_id' => $orderIdSearch]);

                    // End timing
                    $endTime = microtime(true);
                    $timeTaken = $endTime - $startTime;

                    $numRecords = $collection->countDocuments(['order_id' => $orderIdSearch]);

                    // Output the results
                    foreach ($result as $doc) {
                        // Display each document (review) here
                        // Adjust the output to match your document structure
                    }

                    // Output the timing information
                    echo "<div class='timing-results'>";
                     echo "<strong>Query for:</strong> " . $collectionName . ".<br>";
                    echo "<strong>Query Time:</strong> " . number_format($timeTaken, 4) . " seconds<br>";
                    echo "<strong>Number of Records Found:</strong> " . $numRecords;
                    echo "</div>";
                }
            } else {
                echo "<p>Please enter an order ID to search.</p>";
            }
            ?>

        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
