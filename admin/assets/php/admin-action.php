<?php
session_start();
require_once 'authentication.php';
$admin = new Admin();

if (isset($_POST['action']) && $_POST['action'] == 'adminlogin') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $pass = htmlspecialchars($pass, ENT_QUOTES, 'UTF-8');
    $loggedInUser = $admin->admin_login($username, $pass);
    if ($loggedInUser != null) {
        echo 'admin_login';
        $_SESSION['user_admin'] = 'admin';
    } else {
        echo $admin->showMessage("danger", "User not found or password is incorect!!");
    }

}
if (isset($_POST['action']) && $_POST['action'] == 'loadUserData') {
    $userType = $_POST['userType'];
    $output = '';


    if ($userType === 'student') {
        // Fetch student data and return it as JSON
        $students = $admin->getStudentData();
        if ($students) {
            echo ' <table  id="studentDataTable"  class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($students as $row) {

                echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['email'] . '</td>
                                      <td>
                        <button class="view-button btn-secondary rounded" data-id="' . $row['id'] . '">View student Questions</button>
                        <button class="ban-student-button btn-secondary rounded" data-id="' . $row['id'] . '">Ban account</button>
                        <button class="unban-student-button btn-secondary rounded" data-id="' . $row['id'] . '">Unban account</button>

                    </td>
                </tr>';
            }
            $output .= '</table></tbody>';
            echo $output;
        }
    } elseif ($userType === 'teacher') {
        // Fetch teacher data and return it as JSON
        $teachers = $admin->getTeacherData();
        if ($teachers) {
            echo '<table  id="teacherDataTable"  class="table table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Latest Qualification</th>
                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($teachers as $row) {

                echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['latest_qualification'] . '</td>
                    
                    <td>
                        <button class="view-certificate btn-secondary rounded" data-id="' . $row['id'] . '">View Certificate</button>
                        <button class="view-pan btn-secondary rounded" data-id="' . $row['id'] . '">View Pan</button>
                        <button class="accept-button btn-secondary rounded" data-id="' . $row['id'] . '">Accept</button>
                        <button class="reject-button btn-secondary rounded" data-id="' . $row['id'] . '">Reject</button>

                    </td>
                </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        }



    }
}

if (isset($_POST['action']) && $_POST['action'] == 'getCertificatePath') {
    $userId = $_POST['userId'];
    $certificatePath = $admin->getCertificatePath($userId);

    // Assuming $certificatePath is the path to the certificate image
    echo "../../prototype_minor_project/Teacher_panel\assets\img\uploads\certificates/" . $certificatePath;
}
if (isset($_POST['action']) && $_POST['action'] == 'getpanPath') {
    $userId = $_POST['userId'];
    $certificatePath = $admin->getPanPath($userId);

    // Assuming $certificatePath is the path to the certificate image
    echo "../../prototype_minor_project/Teacher_panel\assets\img\uploads\pan_img/" . $certificatePath;
}
if (isset($_POST['action']) && $_POST['action'] == 'accept_certificate') {
    $userId = $_POST['userId'];
    $result = $admin->accept_certificate($userId);
    if ($result) {
        echo 'true';

    } else {
        echo 'false';
    }


}
if (isset($_POST['action']) && $_POST['action'] == 'reject_certificate') {
    $userId = $_POST['userId'];
    $result = $admin->reject_certificate($userId);
    if ($result) {
        echo 'true';

    } else {
        echo 'false';
    }

}
if (isset($_POST['action']) && $_POST['action'] == 'ban_student') {
    $userId = $_POST['userId'];
    $result = $admin->ban_student($userId);
    if ($result) {
        echo 'true';

    } else {
        echo 'false';
    }

}
if (isset($_POST['action']) && $_POST['action'] == 'unban_student') {
    $userId = $_POST['userId'];
    $result = $admin->unban_student($userId);
    if ($result) {
        echo 'true';

    } else {
        echo 'false';
    }

}


if (isset($_POST['action']) && $_POST['action'] == 'view_all_student_questions') {
    $userId = $_POST['userId'];
    $questions = $admin->MyaskedQuestions($userId);


    $output = '<ul >';
    foreach ($questions as $question) {
        $output .= '<li class="question-link">' . $question['question_text'] . '</li>';
    }
    $output .= '</ul>';
    echo $output;

}

if (isset($_POST['action']) && $_POST['action'] == 'display_report_content') {
    $content = $admin->view_reported_content();
    $output = "";
    if ($content) {
        $output .= '<table  id="teacher-report-table"  class="table table-bordered">
        <thead>
            <tr>
                <th>Teacher ID</th>
                <th>Report Reason</th>
                
            
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($content as $row) {

            $output .= '<tr>
            <td>' . $row['teacher_id'] . '</td>
            <td>' . $row['report_reason'] . '</td>
            
            
            <td>
            
            <button class="ban-teacher-button btn-secondary rounded" data-id="' . $row['teacher_id'] . '">Ban account</button>
            <button class="unban-teacher-button btn-secondary rounded" data-id="' . $row['teacher_id'] . '">Unban account</button>

            </td>
        </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
    }

}

if (isset($_POST['action']) && $_POST['action'] == 'ban_teacher') {
    $userId = $_POST['userId'];
    $result = $admin->ban_teacher($userId);
    if ($result) {
        echo 'true';

    } else {
        echo 'false';
    }

}
if (isset($_POST['action']) && $_POST['action'] == 'unban_teacher') {
    $userId = $_POST['userId'];
    $result = $admin->unban_teacher($userId);
    if ($result) {
        echo 'true';

    } else {
        echo 'false';
    }

}

if (isset($_POST['action']) && $_POST['action'] == 'display_query') {
    $content = $admin->view_teacher_query();
    $output = "";
    if ($content) {
        $output .= '<table  id="teacher-query-table"  class="table table-bordered">
        <thead>
            <tr>
                <th>Teacher ID</th>
                <th>Subject</th>
                <th>Query</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($content as $row) {

            $output .= '<tr>
            <td>' . $row['teacher_id'] . '</td>
            <td>' . $row['subject'] . '</td>
            <td>' . $row['query'] . '</td>
            <td>
            
            <button class="query-resolve-button btn-secondary rounded" data-id="' . $row['id'] . '" >Resolve</button>
            
            </td>
            
            
            
         
        </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
    }

}
if (isset($_POST['action']) && $_POST['action'] == 'query_resolve') {
    $userId = $_POST['qid'];
    $result = $admin->query_resolve($userId);
    if ($result) {
        echo 'true';

    } else {
        echo 'false';
    }

}






