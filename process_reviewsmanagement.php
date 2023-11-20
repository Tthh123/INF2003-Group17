<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Reviews">
        <title>Reviews</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            /* Custom CSS for image size */
            .review-image {
                max-width: 100px; /* Adjust the desired maximum width */
                height: auto;
            }
        </style>
    </head>
    <body>

        <div class="container mt-5">
            <h1 class="text-center">Customer Reviews</h1>

            <!-- Add the filtering form with Bootstrap styling -->
            <form action="" method="get" class="mb-4">
                <div class="form-group">
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
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

            <?php
            // Create database connection
            $config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Initialize rating filter value (default to all ratings)
            $ratingFilter = isset($_GET['rating']) ? $_GET['rating'] : null;

            // Define the SQL query to retrieve reviews with optional rating filter
            $sql = "SELECT * FROM reviews";
            if ($ratingFilter) {
                $sql .= " WHERE rating = $ratingFilter";
            }

            // Execute the query
            $result = $conn->query($sql);

            // Directory where your images are stored
            $imageDirectory = 'img/reviews/';

            // Output the retrieved reviews with HTML formatting
            while ($review = $result->fetch_assoc()) {
                echo "<div class='review'>";
                echo "<h3>Order ID: " . $review['order_id'] . "</h3>";
                echo "<p>Name: " . $review['name'] . "</p>";
                echo "<p>Rating: " . $review['rating'] . "</p>";
                echo "<p>Message: " . $review['message'] . "</p>";

                $imageFilename = $review['image_filename'];
                $imagePath = $imageDirectory . $imageFilename;

                if (file_exists($imagePath)) {
                    // Adjust the image size as needed
                    echo "<img src='$imagePath' alt='Review Image' style='max-width: 200px;' />";
                } else {
                    echo "<p>Image not found: $imageFilename</p>";
                }

                // Add more fields as needed
                echo "</div>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>

    </body>
</html>
