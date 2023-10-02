<?php
session_start();

// Check if the form was submitted with an email
if (!isset($_POST['email'])) {
    header('Location: forgetpassword.php');
    exit;
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$firstName = filter_var($_POST['fname'] ?? '', FILTER_SANITIZE_STRING);
$lastName = filter_var($_POST['lname'] ?? '', FILTER_SANITIZE_STRING);
$errorMessage = '';
$success = true;

if (empty($firstName) || empty($lastName)) {
    $success = false;
    $errorMessage = 'Please enter both first and last name.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $success = false;
    $errorMessage = 'Please enter a valid email address.';
}

if ($success) {
    authenticateUser($firstName, $lastName, $email);
}

function authenticateUser($firstName, $lastName, $email) {
    global $errorMessage, $success;
    // Read database configuration from ini file
    $config = parse_ini_file('../../private/db-config.ini');
    // Create database connection
    $mysqli = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($mysqli->connect_error) {
        $errorMessage = "Connection failed: " . $mysqli->connect_error;
        $success = false;
    } else {

        // Prepare and bind the SQL statement
        $stmt = $mysqli->prepare("SELECT * FROM world_of_pets_members WHERE email=? AND fname=? AND lname=?");
        $stmt->bind_param("sss", $email, $firstName, $lastName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {

            // Generate a random security code
            $securityCode = bin2hex(random_bytes(16));
            // Store the security code in a session variable
            $_SESSION['security_code'] = $securityCode;
            $_SESSION['emailsecurity_code'] = $email;
            // Hash the security code
            $hashedSecurityCode = password_hash($securityCode, PASSWORD_DEFAULT);

            // Update the securitycode column for the user in the database
            $sql = "UPDATE world_of_pets_members SET securitycode=? WHERE email=?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $hashedSecurityCode, $email);
            $result = $stmt->execute();

            if (!$result) {
                $errorMessage = "Failed to update the security code. Error: " . $stmt->error;
                $success = false;
            } else {
                // Save the user's email in session variables
                $_SESSION['emailcheck'] = $email;
                // Redirect to securitycode.php
                header('Location: securitycode.php');
                exit;
            }

            $stmt->close();
        } else {
            $errorMessage = "User not found.";
            $success = false;
        }
        $stmt->close();
        $mysqli->close();
    }

    if (!$success) {
        $_SESSION['error_message'] = $errorMessage;
        header('Location: forgetpassword.php'); // Redirect to the login page
        exit;
    } else {

// Redirect to securitycode.php
        header('Location: securitycode.php');
        exit;
    }
}
?>

