<?php
// Read database configuration from ini file
$config = parse_ini_file('../../private/db-config.ini');

// Create database connection
$mysqli = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepare and bind the SQL statement to insert an admin account with hashed password
$stmt = $mysqli->prepare("INSERT INTO world_of_pets_members (fname, lname, email, password, usertype, member_id) VALUES (?, ?, ?, ?, 'admin', 1)");
$fname = "Admin";
$lname = "Account";
$email = "admin@gmail.com";
$password = password_hash("admin", PASSWORD_DEFAULT);
$stmt->bind_param("ssss", $fname, $lname, $email, $password);
$stmt->execute();
$stmt->close();

// Close database connection
$mysqli->close();
?>
