<?php

session_start();
require_once "authentication.php";


if (!isset($_SESSION['user'])) {
    header("Location: http://localhost/prototype_minor_Project/landing_page/index.php");
    exit; // It's common to use "exit" instead of "die" for terminating the script.
}



