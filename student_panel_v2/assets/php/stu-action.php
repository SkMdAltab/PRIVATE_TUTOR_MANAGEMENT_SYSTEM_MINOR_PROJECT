<?php
require_once 'session.php';
require_once 'stu-methods.php';
$user_new4 = new StuMethods();

if (isset($_POST['action']) && $_POST['action'] == 'select_subject') {
    $subject = $_POST['subject'];
    $locations = array();


    $all_locations = $user_new4->get_location_on_subject($subject);

    foreach ($all_locations as $location) {
        $locations[] = $location['city'];
    }

    echo json_encode(array('locations' => $locations));
}

if (isset($_POST['action']) && $_POST['action'] == 'get_teachers') {
    $subject = $_POST['subject'];
    $location = $_POST['location'];

    // Query the database to fetch teachers based on subject and location
    // Construct your SQL query accordingly
    $teachers = $user_new4->search_result_teacher($subject, $location);
    if ($teachers) {
        // Initialize an empty HTML string to store the results
        $teacherResults = '';

        // Loop through $teachers and generate the HTML for each teacher
        foreach ($teachers as $teacher) {
            $teacherResults .= '<div class="col-md-4 col-xl-4 mb-4 mt-2">';
            $teacherResults .= '<div class="card shadow card-style1" style="border-radius: 15px;">';
            $teacherResults .= '<div class="card-body text-center">';
            $teacherResults .= '<div class="mt-3 mb-4">';
            $teacherResults .= '<img src="../teacher_panel/assets/img/uploads/profile_pic/' . $teacher['profile_pic'] . '" class="teacher-profile-pic" />';
            $teacherResults .= '</div>';
            $teacherResults .= '<h4 class="mb-2">' . $teacher['name'] . '</h4>';
            $teacherResults .= '<span class="text-truncate" style="max-width: 200px; display: inline-block;">Subjects: ' . $teacher['subjects'] . '</span>';
            $teacherResults .= '<p class="text-muted mb-4">Qualification: ' . $teacher['latest_qualification'] . '</p>';
            $teacherResults .= '<div class="mb-2 pb-2">';

            // Star rating logic
            $fullStars = floor($teacher['overall_ratings']); // Get the full stars
            $halfStar = ($teacher['overall_ratings'] - $fullStars) > 0; // Check for a half star

            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $fullStars) {
                    $teacherResults .= '<i class="fas fa-star star" data-rating="' . $i . '"></i>';
                } elseif ($halfStar && $i == ($fullStars + 1)) {
                    $teacherResults .= '<i class="fas fa-star-half-alt star" data-rating="' . $i . '"></i>';
                } else {
                    $teacherResults .= '<i class="far fa-star star" data-rating="' . $i . '"></i>';
                }
            }

            $teacherResults .= '</div>';
            $teacherResults .= '<a href="teacher-details-page.php?teacher_id=' . $teacher['id'] . '" class="btn btn-primary btn-rounded btn-md">View Full Profile</a>';
            $teacherResults .= '<div class="d-flex justify-content-center text-center mt-2 mb-2">';
            $teacherResults .= '<div>';
            $teacherResults .= '<p class="mb-1 h5">' . $teacher['no_of_ratings'] . '</p>';
            $teacherResults .= '<p class="text-muted mb-0">No of Ratings</p>';
            $teacherResults .= '</div>';
            $teacherResults .= '</div>';
            $teacherResults .= '</div>';
            $teacherResults .= '</div>';
            $teacherResults .= '</div>';
        }

        // Return the teacher results as JSON
        echo $teacherResults;
    } else {
        echo "<h1>No Result Found</h1>";
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'ask-question') {

    $student_id = $_POST['student_id'];
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $question = filter_var($_POST['question'], FILTER_SANITIZE_STRING);
    $tag = $subject;
    $result = $user_new4->insertQuestionTable($student_id, $question, $tag);
    if ($result) {
        echo "true";
    }



}
if (isset($_POST['action']) && $_POST['action'] == 'search-question') {

    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);

    $tag = $subject;

    echo $tag;



}
if (isset($_POST['action']) && $_POST['action'] == 'click_question') {

    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);

    $tag = $subject;

    echo $tag;

}
if (isset($_POST['action']) && $_POST['action'] == 'rate_teacher_answer') {



    $answerId = $_POST['answerId'];
    $rating = $_POST['rating'];
    $teacherId = $_POST['teacherId'];
    $studentId = $_POST['studentId'];
    $result = $user_new4->hasStudentRatedAnswer($answerId, $studentId);

    if (!$result) {
        $user_new4->updateRating($answerId, $rating, $teacherId, $studentId);
        echo 'true';
    } else {

        echo "false";
    }



}


if (isset($_POST['action']) && $_POST['action'] == 'basic_details') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

    if ($user_new4->change_name_details($name, $cid)) {
        echo "true";
    } else {
        echo "false";
    }
}


if (isset($_POST['action']) && $_POST['action'] == 'changePass') {
    $oldpass = filter_var($_POST['curpass'], FILTER_SANITIZE_STRING);
    $new_pass = filter_var($_POST['newpass'], FILTER_SANITIZE_STRING);

    $hash_pass = password_hash($new_pass, PASSWORD_DEFAULT);

    if (password_verify($oldpass, $cpass)) {
        $user_new4->update_new_pass($hash_pass, $current_email);
        echo "true";
    } else {
        echo 'false';
    }
}


//handle fetch notification
if (isset($_POST['action']) && $_POST['action'] == 'fetchNotification') {
    $notification = $user_new4->fetchNotification($cid);
    $output = '';
    if ($notification) {
        foreach ($notification as $row) {
            $output .= '<div class="alert alert-danger  clearfix" role="alert">
        <button type="button" id="' . $row['id'] . '" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="alert-heading"> New notification</h4>
        <p class="mb-0 lead">' . $row['message'] . '</p>
        <hr class="my-2">
        <p class="mb-0 float-left">From Teacher </p>
        <p class="mb-0 float-right">' . $user_new4->timeInAgo($row['created_at']) . ' </p>

    </div>';
        }
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary mt-5">No new notification</h3>';
    }

}

//handle check notification
if (isset($_POST['action']) && $_POST['action'] == 'checkNotification') {
    if ($user_new4->fetchNotification($cid)) {
        echo '<i class="fas fa-circle text-danger fa-sm"></i>';
    } else {
        echo '';
    }

}

//remove notification
if (isset($_POST['notification_id'])) {
    $id = $_POST['notification_id'];
    $user_new4->removeNotification($id);

}

if (isset($_POST['action']) && $_POST['action'] == 'report_form_submit') {
    $answerId = $_POST['answer_id'];
    $teacherId = $_POST['teacher_id'];
    $reportReason = $_POST['report_reason'];

    $result = $user_new4->hasStudentReport($answerId, $cid);

    if (!$result) {
        $user_new4->insertReport($answerId, $teacherId, $cid, $reportReason);
        echo 'true';
    } else {

        echo "false";
    }



}










?>