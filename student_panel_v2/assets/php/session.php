<?php
require_once 'stu-methods.php';


session_start();
if (!isset($_SESSION['user_student'])) {
    // Redirect to the login page if user_type is not set
    header("Location: http://localhost/prototype_minor_Project/landing_page/index.php");
    exit;
}
$stu_user = new StuMethods();

$current_email = $_SESSION['user_stu'];
$data = $stu_user->currentUser($current_email);
$cid = $data['id'];
$cname = $data['name'];
$cpass=$data['password'];
$ban_status=$data['ban_status'];
$all_subjects = $stu_user->get_all_subjects();
$all_subjects = $all_subjects['subject_names'];
$all_subjects = explode(',', $all_subjects);

