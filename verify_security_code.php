<?php
session_start();

if (!isset($_POST['security_code']) || !isset($_SESSION['emailcheck'])) {
    header('Location: forgetpassword.php');
    exit;
}

$submittedSecurityCode = filter_input(INPUT_POST, 'security_code', FILTER_SANITIZE_STRING);
$email = $_SESSION['emailcheck'];
unset($_SESSION['security_code']);
$errorMessage = '';
$success = true;

$config = parse_ini_file('../../private/db-config.ini');
$mysqli = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

if ($mysqli->connect_error) {
    $errorMessage = "Connection failed: " . $mysqli->connect_error;
    $success = false;
} else {
    $stmt = $mysqli->prepare("SELECT securitycode FROM world_of_pets_members WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHashedSecurityCode = $row['securitycode'];

        if (password_verify($submittedSecurityCode, $storedHashedSecurityCode)) {
            header('Location: changepassword.php');
            exit;
        } else {
            $errorMessage = "Incorrect security code.";
            $success = false;
        }
    } else {
        $errorMessage = "User not found.";
        $success = false;
    }
    $stmt->close();
    $mysqli->close();
}

if (!$success) {
    $_SESSION['error_message'] = $errorMessage;
    header('Location: securitycode.php');
    exit;
}
?>
