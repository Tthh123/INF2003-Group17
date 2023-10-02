<?php

session_start();

// Create database connection
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Validate and Sanitize User Input for create product
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
$brand = filter_var(trim($_POST['brand']), FILTER_SANITIZE_STRING);
$quantity = filter_var(trim($_POST['quantity']), FILTER_VALIDATE_INT);
$price = filter_var(trim($_POST['price']), FILTER_VALIDATE_FLOAT);
$link = filter_var(trim($_POST['link']), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9\/\.\-\_]+$/")));
$imageSrc = $_POST['imageSrc'];
$description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);
$category = filter_var(trim($_POST['category']), FILTER_SANITIZE_STRING);

// Check if input is valid
if ($name && $brand && $quantity !== false && $price !== false && $link && $description && $category) {


    // Check if product already exists
    $stmt = $conn->prepare("SELECT name FROM products WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['product_exists'] = true;
        $stmt->close();
        $conn->close();
        header("Location: admin.php");
        exit();
    }
    $stmt->close();

    // Product does not exist, proceed with creating it
    $stmt = $conn->prepare("INSERT INTO products (name, brand, quantity, price, link, imageSrc, description, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidssss", $name, $brand, $quantity, $price, $link, $imageSrc, $description, $category);
    if ($stmt->execute()) {
        $successMsg = "Product created successfully";
        $success = true;
    } else {
        // Invalid input, show error message
        $errorMsg = 'Please fill in all fields with valid input.';
        $_SESSION['error_msg'] = $errorMsg;
        $success = false;
    }

    $stmt->close();

    if ($success) {
        $_SESSION['product_created'] = true;
        // Redirect to the products page
        header("Location: admin.php");
        exit();
    } else {
        $errorMsg = 'Please fill in all fields with valid input.';
        $_SESSION['error_msg'] = $errorMsg;
        header("Location: admin.php");
    }
} else {
    // Invalid input, show error message
    $_SESSION['error_msg'] = 'Please fill in all fields with valid input.';
    header("Location: admin.php");
}

// Close MySQL connection
$conn->close();
