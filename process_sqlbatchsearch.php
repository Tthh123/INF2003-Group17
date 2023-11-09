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
            // Only process if form is submitted
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Gather form data
                $ratingFilter = isset($_GET['rating']) ? $_GET['rating'] : '';
                $rowCount = isset($_GET['rows']) ? (int) $_GET['rows'] : 1000;
                $nameSearch = isset($_GET['nameSearch']) ? $_GET['nameSearch'] : '';
                $messageSearch = isset($_GET['messageSearch']) ? $_GET['messageSearch'] : '';

                // Construct SQL conditions
                $conditions = [];
                if (!empty($nameSearch)) {
                    $conditions[] = "name LIKE '%" . $conn->real_escape_string($nameSearch) . "%'";
                }
                if (!empty($messageSearch)) {
                    $conditions[] = "message LIKE '%" . $conn->real_escape_string($messageSearch) . "%'";
                }
                if (!empty($ratingFilter)) {
                    $conditions[] = "rating = " . $conn->real_escape_string($ratingFilter);
                }

                // Initialize an array to hold the performance results
                $performanceResults = [];
                $tables = ['reviews', 'reviews1', 'reviews2'];
                $indexTypes = [
                    'reviews' => 'No Indexes',
                    'reviews1' => 'Individual Indexes',
                    'reviews2' => 'Composite Index'
                ];

                // Search and display for each table
                foreach ($tables as $table) {
                    $sql = "SELECT * FROM $table";
                    if ($conditions) {
                        $sql .= " WHERE " . implode(' AND ', $conditions);
                    }

                    $sql .= " LIMIT " . $rowCount;

                    // Start timing
                    $startTime = microtime(true);

                    // Execute the query
                    $result = $conn->query($sql);

                    // End timing
                    $endTime = microtime(true);

                    // Calculate the duration
                    $timeTaken = $endTime - $startTime;

                    // Count the records
                    $numRecords = $result->num_rows;

                    // Collect the performance metrics
                    $performanceResults[$table] = [
                        'timeTaken' => $timeTaken,
                        'numRecords' => $numRecords,
                        'indexType' => $indexTypes[$table]
                    ];
                }

                // Display the performance metrics
                echo "<div class='timing-results-container'>";
                foreach ($performanceResults as $tableName => $metrics) {
                    echo "<div class='timing-results'>";
                    echo "<p>Table: $tableName ({$metrics['indexType']})</p>";
                    echo "<p>Time Taken: " . sprintf('%.4f', $metrics['timeTaken']) . " seconds</p>";
                    echo "<p>Records Found: {$metrics['numRecords']}</p>";
                    echo "</div>";
                }
                echo "</div>";
                
                // Display the results if any records found, limited to 10 rows
                if ($numRecords > 0 && $displayedRowCount < 10) {
                    $imageDirectory = 'img/reviews';
                    while ($review = $result->fetch_assoc()) {
                        echo "<div class='review'>";
                        echo "<h3>Order ID: " . htmlspecialchars($review['order_id']) . "</h3>";
                        echo "<p>Name: " . htmlspecialchars($review['name']) . "</p>";
                        echo "<p>Rating: " . str_repeat('&#9733;', $review['rating']) . " Stars</p>";
                        echo "<p>Message: " . htmlspecialchars($review['message']) . "</p>";

                        $imageFilename = htmlspecialchars($review['image_filename']);
                        $imagePath = $imageDirectory . '/' . $imageFilename; // Fix image path
                        if (file_exists($imagePath)) {
                            echo "<img src='$imagePath' alt='Review Image' class='review-image' />";
                        } else {
                            echo "<p>Image not found: $imageFilename</p>";
                        }
                        echo "</div>";
                        $displayedRowCount++; // Increment the displayed row counter
                    }
                }
                echo "<hr>";
            }

            $conn->close();
            ?>
            
            
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>