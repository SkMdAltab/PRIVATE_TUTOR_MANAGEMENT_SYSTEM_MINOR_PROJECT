<?php

require_once "tea-methods.php";
session_start();
if (!isset($_SESSION['user_teacher'])) {
    // Redirect to the login page if user_type is not set
    header("Location: http://localhost/prototype_minor_Project/landing_page/index.php");
    die;
}
$tea_user = new TeaMethods();

$current_email = $_SESSION['user'];
$data = $tea_user->currentUser($current_email);
$cid = $data['id'];
$cname = $data['name'];
$cpass = $data['password'];
$cphone = $data['phone'];
$cphoto = $data['profile_pic'];
$cabout = $data['about_me'];
$csubjects = $data['subjects'];
$ban_status = $data['ban_status'];
$approve_certificate = $data['approve_certificate'];
$overall_ratings = $data['overall_ratings'];
$no_of_ratings = $data['no_of_ratings'];
if (!empty($csubjects)) {
    $csubjects = explode(',', $csubjects);
}

$all_subjects = $tea_user->get_all_subjects();
$all_subjects = $all_subjects['subject_names'];
$all_subjects = explode(',', $all_subjects);


$chome_address = $data['Home_address'];
$city = $data['city'];
$pin = $data['pin'];
$latest_qualification = $data['latest_qualification'];




// if ($verified == 1) {
//     $verified = 'verified';

// } else {
//     $verified = 'not verified';
// }