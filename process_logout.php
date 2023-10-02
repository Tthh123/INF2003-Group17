<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Unset the email session variable
unset($_SESSION['email']);
unset($_SESSION['emailcheck']);


// Redirect to the logout page
header('Location: logout.php');
exit;
?>
