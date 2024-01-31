<?php
require_once 'session.php';


if (isset($_POST['action']) && $_POST['action'] == 'changePass') {
    $oldpass = filter_var($_POST['curpass'], FILTER_SANITIZE_STRING);
    $new_pass = filter_var($_POST['newpass'], FILTER_SANITIZE_STRING);

    $hash_pass = password_hash($new_pass, PASSWORD_DEFAULT);

    if (password_verify($oldpass, $cpass)) {
        $tea_user->update_new_pass($hash_pass, $current_email);
        echo "true";
    } else {
        echo 'false';
    }
}
if (isset($_FILES['profile_img'])) {

    $oldImage = $_POST['oldimage'];
    $allowedExtensions = array('jpg', 'png', 'jpeg');
    $image_path = $tea_user->uploadFile('profile_img', '../img/uploads/profile_pic/', $allowedExtensions, $cid);
    if ($image_path) {
        if ($oldImage != null) {
            unlink($oldImage);
        }
        $tea_user->update_profile_photo($image_path, $cid);
        // $tea_user->notification($uid, 'admin', 'Profile Updated');

    } else {
        $image_path = $oldImage;
        $tea_user->update_profile_photo($image_path, $cid);
    }

}
if (isset($_POST['action']) && $_POST['action'] == 'basic_details') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $about_me = filter_var($_POST['about_me'], FILTER_SANITIZE_STRING);
    if ($tea_user->change_basic_details($name, $about_me, $cid)) {
        echo "true";
    } else {
        echo "false";
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'contact_details') {
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $homeAddress = filter_var($_POST['homeAddress'], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $city = strtoupper($city);
    $pin = filter_var($_POST['pin'], FILTER_SANITIZE_STRING);
    if ($tea_user->change_contact_details($phone, $homeAddress, $city, $pin, $cid)) {
        if ($tea_user->is_city_exist($city)) {
            echo "true";

        } else {
            $tea_user->update_location($city);
            echo "true";
        }

    } else {
        echo "false";
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'subject_selection') {
    $new_sub = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    if (!empty($csubjects)) {


        // Check if the new subject exists in the array
        if (!in_array($new_sub, $csubjects)) {
            // Add the new subject to the array
            $csubjects[] = $new_sub;

            // Convert the array back to a comma-separated string
            $updated_subjects = implode(',', $csubjects);

            // Update the subjects
            $tea_user->change_subjects($updated_subjects, $cid);
            $tea_user->insert_new_location_subject($city, $new_sub);

            echo 'true';
        } else {
            echo '';
        }
    } else {
        // If $csubjects is empty, set the new subject as the only subject
        $tea_user->change_subjects($new_sub, $cid);
        $tea_user->insert_new_location_subject($city, $new_sub);
        echo 'true';
    }




}

//for changing toggle button status 
if (isset($_POST['status'])) {

    $status = $_POST['status'];
    if ($tea_user->toggle_set($cid, $status)) {
        echo 'true';
    } else {
        echo 'false';
    }



}

if (isset($_POST['action']) && $_POST['action'] == 'check_teacher_status') {

    $result = $tea_user->check_active_status($cid);
    echo $result;

}

if (isset($_POST['action']) && $_POST['action'] === 'submit_answer') {
    // Get the question ID and answer from the POST data
    $questionID = $_POST['question_id'];
    $question_text = $_POST['question_text'];
    $uid = $_POST['student_id'];
    $answerText = $_POST['answer'];

    $message = "Your question \"" . $question_text . "has been answered: " . "\" by " . $cname;
    // Call a method in your TeaMethods class to insert the answer into the database
    $success = $tea_user->insertAnswer($questionID, $answerText, $cid);
    $tea_user->notification($uid, $message);

    // Return a response to the client-side based on the success of the operation
    if ($success) {
        echo 'success';
    } else {
        echo 'error';
    }
}


if (isset($_POST['action']) && $_POST['action'] == 'fetch_answer') {

    $answerID = $_POST['answer_id'];
    $result = $tea_user->get_edit_answer($answerID);


    echo $result;


    exit; // Ensure nothing else is sent in the response

}

if (isset($_POST['action']) && $_POST['action'] === 'contact_with_admin') {
    $subject = $_POST['subject'];
    $query = $_POST['query'];
    if ($tea_user->send_teacher_query($subject, $query, $cid)) {
        echo 'true';
    } else {
        echo 'false';
    }


}

if (isset($_POST['action']) && $_POST['action'] == 're_upload_certificate') {
    $allowedExtensions = array('jpg', 'png', 'jpeg');
    $certificate_path = $tea_user->re_upload_certificate('certificate_img_admin', '../img/uploads/certificates/', $allowedExtensions);
    $pan_path = $tea_user->re_upload_certificate('pan_img_admin', '../img/uploads/pan_img/', $allowedExtensions);
    if ($certificate_path && $pan_path) {
        $tea_user->update_certifi_pan_path($cid, $certificate_path, $pan_path);
    }


}







?>