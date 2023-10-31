<?php

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $name = $_POST['name'];
    $rating = $_POST['rating'];
    $message = $_POST['message'];

    $conn->autocommit(false); // Start a transaction

    // Check if an image was uploaded
    if (isset($_FILES['review_image'])) {
        // Get the uploaded image filename
        $imageFilename = $_FILES['review_image']['name'];
        $tmp = $_FILES['review_image']['tmp_name'];
        // Set the full path to the target location
        $targetPath = 'img/reviews/' . $imageFilename;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmp, $targetPath)) {
            // Successfully moved the file, now insert the data into the database
            $stmt = $conn->prepare("INSERT INTO reviews (order_id, name, rating, message, image_filename) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiss", $order_id, $name, $rating, $message, $imageFilename);

            if ($stmt->execute()) {
                $success = true;
                $conn->commit(); // Commit the transaction
            } else {
                $errorMsg = "Error: " . $stmt->error;
                $success = false;
                $conn->rollback(); // Roll back the transaction
            }
        } else {
            $errorMsg = "Error moving the uploaded file.";
            $success = false;
            $conn->rollback(); // Roll back the transaction
        }
        $stmt->close();
    }

    $conn->autocommit(true); // Revert to autocommit mode

    // Close the database connection
    mysqli_close($conn);

    // Redirect back to the form page with a success or error message
    if ($success) {
        header("Location: reviewscompleted.php?success=1");
    } else {
        header("Location: reviewscompleted.php?error=" . urlencode($errorMsg));
    }
}
?>
