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
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $indexTypes = [
        'reviews' => 'No Indexes',
        'reviews1' => 'Individual Indexes',
        'reviews2' => 'Composite Index'
    ];

    $performanceMetrics = [];

    if (isset($_GET['orderIdSearch']) && $_GET['orderIdSearch'] != '') {
        $orderIdSearch = $_GET['orderIdSearch'];

        foreach ($indexTypes as $tableName => $indexType) {
            $sql = "SELECT * FROM $tableName WHERE order_id LIKE ?";
            $stmt = $conn->prepare($sql);
            $searchTerm = "%$orderIdSearch%";
            $stmt->bind_param("s", $searchTerm);

            $startTime = microtime(true);
            $stmt->execute();
            $result = $stmt->get_result();
            $endTime = microtime(true);

            $timeTaken = $endTime - $startTime;
            $numRecords = $result->num_rows;

            $performanceMetrics[$tableName] = [
                'timeTaken' => $timeTaken,
                'numRecords' => $numRecords,
                'indexType' => $indexType
            ];

            // Assume we only want to display results from the 'reviews' table for simplicity
            if ($tableName == 'reviews') {
                $imageDirectory = 'img/reviews/';
                while ($review = $result->fetch_assoc()) {
                    echo "<div class='review'>";
                    echo "<h3>Order ID: " . htmlspecialchars($review['order_id']) . "</h3>";
                    echo "<p>Name: " . htmlspecialchars($review['name']) . "</p>";
                    echo "<p>Rating: " . str_repeat('&#9733;', $review['rating']) . " Stars</p>";
                    echo "<p>Message: " . htmlspecialchars($review['message']) . "</p>";

                    $imageFilename = htmlspecialchars($review['image_filename']);
                    $imagePath = $imageDirectory . $imageFilename;
                    if (file_exists($imagePath)) {
                        echo "<img src='$imagePath' alt='Review Image' class='review-image' />";
                    } else {
                        echo "<p>Image not found: $imageFilename</p>";
                    }
                    echo "</div>";
                }
            }
            $stmt->close();
        }

        // Output the timing information
        echo "<div class='timing-results-container'>";
        foreach ($performanceMetrics as $tableName => $metrics) {
            echo "<div class='timing-results'>";
            echo "<p>Table: $tableName (Index Type: {$metrics['indexType']})</p>";
            echo "<strong>Query Time:</strong> " . number_format($metrics['timeTaken'], 4) . " seconds<br>";
            echo "<strong>Number of Records Found:</strong> " . $metrics['numRecords'];
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>Please enter an order ID to search.</p>";
    }

    $conn->close();
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
