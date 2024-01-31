<?php
session_start(); // Start or resume the session



unset($_SESSION['user_student']);
// Redirect the user to the login page after logout
header("Location:http://localhost/prototype_minor_Project/landing_page/index.php");
exit();
?>