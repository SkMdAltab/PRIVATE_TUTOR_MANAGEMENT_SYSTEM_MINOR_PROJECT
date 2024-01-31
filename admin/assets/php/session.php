<?php

session_start();
if (!isset($_SESSION['user_admin'])) {
    // Redirect to the login page if user_type is not set
    header("Location: index.php");
    exit;
} 


