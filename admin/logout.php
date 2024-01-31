<?php
session_start(); // Start or resume the session

unset($_SESSION['user_admin']);
// Redirect the user to the login page after logout
header("Location:index.php");
exit();
?>