<?php
$email = $_POST["email"];

// sanitize the email input
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

// validate the email input
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

// Retrieve categories of the products from the database
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get the email parameter from the POST request
$email = mysqli_real_escape_string($conn, $_POST["email"]);

// insert the email into the database
$sql = "INSERT INTO emails (email) VALUES ('$email')";
if (mysqli_query($conn, $sql)) {
    //echo "Email added successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// close connection
mysqli_close($conn);
?>