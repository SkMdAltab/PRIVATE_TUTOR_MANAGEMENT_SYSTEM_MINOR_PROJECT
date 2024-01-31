<?php
session_start(); // Start or resume the session

// Clear all session data
//session_unset(); // Unset all session variables
//ession_destroy(); // Destroy the session

unset($_SESSION['user_teacher']);
// Redirect the user to the login page after logout
header("Location:http://localhost/prototype_minor_Project/landing_page/index.php");
exit();
//checking git  vs code
?>