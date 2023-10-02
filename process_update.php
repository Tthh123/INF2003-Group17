<?php

session_start();

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
function sanitize_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Update Product
$name = sanitize_input($_POST['name']);
$brand = sanitize_input($_POST['brand']);
$quantity = sanitize_input($_POST['quantity']);
$price = sanitize_input($_POST['price']);
$imageSrc = htmlspecialchars($_POST['imageSrc'], ENT_QUOTES);
$link = htmlspecialchars($_POST['link'], ENT_QUOTES);
$description = sanitize_input($_POST['description']);
$category = sanitize_input($_POST['category']);

// Check if the product exists in the products table
$productQuery = "SELECT * FROM products WHERE name = '$name'";
$result = $conn->query($productQuery);
if ($result->num_rows == 0) {
    $_SESSION['product_not_exist'] = true;
    // Redirect to the edit product page
    header("Location: admin.php");
    exit();
}

// Validate inputs
if (!is_numeric($quantity) || !is_numeric($price)) {
    $errorMsg = "Quantity and Price must be numeric";
    $success = false;
} else {
    // Prepare the statement
    $stmt = $conn->prepare("UPDATE products SET brand=?, quantity=?, price=?, imageSrc=?, link=?, description=?, category=? WHERE name=?");

    // Bind the parameters
    $stmt->bind_param("sidsssss", $brand, $quantity, $price, $imageSrc, $link, $description, $category, $name);

    // Execute the statement
    if ($stmt->execute()) {
        $successMsg = "Product updated successfully";
        $success = true;
    } else {
        $errorMsg = "Error updating product: " . $conn->error;
        $success = false;
    }

    // Redirect to the edit product page
    header("Location: admin.php");

    $stmt->close();

    if ($success) {
        $_SESSION['product_updated'] = true;
        exit();
    } else {
        // Show error message
        $errorMsg = $successMsg;
        header("Location: admin.php");
    }
}

// Close MySQL connection
$conn->close();
