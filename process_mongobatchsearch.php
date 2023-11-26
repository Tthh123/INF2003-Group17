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
            .timing-info {
                margin-top: 10px;
                font-style: italic;
            }
            .review {
                border: 1px solid #dee2e6;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 10px;
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
            <h1 class="text-center">Batch Search Customer Reviews</h1>

            <form action="" method="get" class="mb-4">
                <div class="form-row">
                    <div class="col">
                        <label for="nameSearch">Search by Name:</label>
                        <input type="text" class="form-control" id="nameSearch" name="nameSearch" placeholder="Name">
                    </div>
                    <div class="col">
                        <label for="messageSearch">Search by Message:</label>
                        <input type="text" class="form-control" id="messageSearch" name="messageSearch" placeholder="Message">
                    </div>
                    <div class="col">
                        <label for="ratingFilter">Filter by Star Rating:</label>
                        <select class="form-control" id="ratingFilter" name="rating">
                            <option value="">All Ratings</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="rowCount">Number of Rows:</label>
                        <select class="form-control" id="rowCount" name="rows">
                            <option value="1000">1000 Rows</option>
                            <option value="10000">10K Rows</option>
                            <option value="50000">50K Rows</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Search & Filter</button>
            </form>

            <?php
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
            require 'vendor/autoload.php'; // Include the Composer autoload file

            $mongoDBClient = new MongoDB\Client("mongodb://localhost:27017");
            $database = $mongoDBClient->selectDatabase('NoSQLDatabase');
            $collections = $database->listCollections();

            if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {
                $nameSearch = $_GET['nameSearch'] ?? '';
                $messageSearch = $_GET['messageSearch'] ?? '';
                $ratingFilter = $_GET['rating'] ?? '';
                $rowCount = (int) $_GET['rows'] ?? 1000;
                foreach ($collections as $collectionInfo) {
                    $collectionName = $collectionInfo->getName();
                    $collection = $database->selectCollection($collectionName);
                    $pipeline = [];

                    // Add match stage for name search
                    if ($nameSearch !== '') {
                        $pipeline[] = ['$match' => ['name' => new MongoDB\BSON\Regex($nameSearch, 'i')]];
                    }

                    // Add match stage for message search
                    if ($messageSearch !== '') {
                        $pipeline[] = ['$match' => ['message' => new MongoDB\BSON\Regex($messageSearch, 'i')]];
                    }

                    // Add match stage for rating filter
                    if ($ratingFilter !== '') {
                        $pipeline[] = ['$match' => ['rating' => $ratingFilter]];
                    }

                    // Add limit stage
                    $pipeline[] = ['$limit' => $rowCount];

                    // Start timing
                    $startTime = microtime(true);

                    try {
                        // Perform the search with filters
                        $cursor = $collection->aggregate($pipeline);
                        // Retrieve the count result
                        $countResult = $cursor->toArray();
                        $count = count($countResult);
                    } catch (Exception $e) {
                        echo 'MongoDB Query Error: ' . $e->getMessage();
                    }
                    // End timing
                    $endTime = microtime(true);
                    $timeTaken = $endTime - $startTime;

                    // Output the timing information
                    echo "<div class='timing-results'>";
                    echo "<strong>Query Time:</strong> " . number_format($timeTaken, 4) . " seconds<br>";
                    echo "<strong>Number of Records Found:</strong> " . $count;
                    echo "</div>";
                }
            } else {
                echo "<p>Please enter search criteria.</p>";
            }
            ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>