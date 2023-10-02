<?php
session_start();

if (!isset($_POST['new_password']) || !isset($_POST['confirm_password']) || !isset($_SESSION['emailcheck'])) {
    header('Location: changepassword.php');
    exit;
}

$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];
$email = filter_var($_SESSION['emailcheck'], FILTER_SANITIZE_EMAIL);

// Add this function to the process_changepassword.php file
function isValidPassword($password) {
    if (strlen($password) < 8) {
        return false;
    }
    
    if (!preg_match("/[A-Z]/", $password)) {
        return false;
    }
    
    if (!preg_match("/[a-z]/", $password)) {
        return false;
    }
    
    if (!preg_match("/\d/", $password)) {
        return false;
    }
    
    return true;
}

if (empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
    $_SESSION['error_message'] = "Please enter both new password and confirm password.";
    header('Location: changepassword.php');
    exit;
}

// Add this to the section where you validate the new password and confirm password match
if (!isValidPassword($newPassword)) {
    $_SESSION['error_message'] = "The new password must be at least 8 characters long, with at least one uppercase letter, one lowercase letter, and one number.";
    header('Location: changepassword.php');
    exit;
}

if ($newPassword !== $confirmPassword) {
    $_SESSION['error_message'] = "New password and confirm password do not match.";
    header('Location: changepassword.php');
    exit;
}

$config = parse_ini_file('../../private/db-config.ini');
$mysqli = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("UPDATE world_of_pets_members SET password=? WHERE email=?");
$stmt->bind_param("ss", $hashedPassword, $email);
if ($stmt->execute()) {
    echo "<script>
            alert('Password successfully changed.');
            window.location.href='index.php';
          </script>";
} else {
    $_SESSION['error_message'] = "Failed to update password. Error: " . $stmt->error;
    header('Location: changepassword.php');
    exit;
}

$stmt->close();
$mysqli->close();
?>
