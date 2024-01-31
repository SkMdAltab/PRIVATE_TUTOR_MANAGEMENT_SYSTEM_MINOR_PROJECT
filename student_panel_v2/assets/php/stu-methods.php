<?php
require_once 'stu-connection.php';
class StuMethods extends Database
{
    public function showMessage($type, $msg)
    {
        $style = "style='animation: fallIn 2s forwards;'";

        return "<div class='alert alert-$type alert-dismissible' $style>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong class='text-center'>$msg</strong>
            </div>
            <script>
                setTimeout(function() {
                    var alertElement = document.querySelector('.alert.alert-$type');
                    alertElement.remove();
                }, 10000);
            </script>";
    }

    public function getTeacherData($teacherId)
    {
        $sql = "SELECT name,profile_pic, Home_address, phone, email, about_me, city, pin, latest_qualification, subjects, overall_ratings, no_of_ratings
        FROM teacher_reg
        WHERE id = :teacherId AND ban_status != 1 AND active = 1";

        $stmt = $this->pdo->prepare($sql);

        // Bind the teacherId parameter
        $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $teacherData = $stmt->fetch(PDO::FETCH_ASSOC);


        return $teacherData;
    }
    public function get_best_teacher()
    {
        $sql = "SELECT id,name,profile_pic,latest_qualification, subjects, overall_ratings, no_of_ratings,
        (overall_ratings * (1 + LOG10(no_of_ratings))) AS weighted_rank
    FROM teacher_REG
    WHERE ban_STATUS != 1 AND active = 1
    ORDER BY weighted_rank DESC
    LIMIT 6";

        $stmt = $this->pdo->prepare($sql);



        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $teacherData = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return $teacherData;
    }
    public function search_result_teacher($subject, $location)
    {
        $sql = "SELECT id, name, profile_pic, latest_qualification, subjects, overall_ratings, no_of_ratings,
            (overall_ratings * (1 + LOG10(no_of_ratings))) AS weighted_rank
        FROM teacher_REG
        WHERE ban_STATUS != 1 AND active = 1";

        if ($subject != 'all_subjects' && $location != 'all_locations') {
            $sql .= " AND subjects LIKE CONCAT('%', :subject, '%') AND city = :location";
        } elseif ($location != 'all_locations') {
            $sql .= " AND city = :location";
        } elseif ($subject != 'all_subjects') {
            $sql .= " AND subjects LIKE CONCAT('%', :subject, '%')";
        }

        $stmt = $this->pdo->prepare($sql);

        if ($subject != 'all_subjects') {
            $stmt->bindParam(':subject', $subject);
        }

        if ($location != 'all_locations') {
            $stmt->bindParam(':location', $location);
        }

        $stmt->execute();
        $teacherData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $teacherData;
    }

    public function get_all_subjects()
    {
        $sql = "SELECT subject_names FROM all_subjects";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    public function get_location_on_subject($subject)
    {
        if ($subject == 'all_subjects') {
            $sql = "SELECT city FROM location";
            $stmt = $this->pdo->prepare($sql);


            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } else {
            $sql = "SELECT city FROM location where location_subjects LIKE CONCAT('%', :subject, '%') ";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':subject', $subject);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

    }

    public function currentUser($email)
    {


        $sql = "SELECT * FROM student_reg WHERE email = :email ";


        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;

    }

    public function insertQuestionTable($student_id, $question_text, $question_tag)
    {
        // Define your SQL query to insert a new record into the question_table
        $sql = "INSERT INTO questions (student_id, question_text, question_tag) VALUES (:student_id, :question_text, :question_tag)";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);

        // Bind the parameters
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':question_text', $question_text);
        $stmt->bindParam(':question_tag', $question_tag);

        // Execute the query
        $result = $stmt->execute();

        // Check if the insertion was successful
        if ($result) {
            return true; // Insertion successful
        } else {
            return false; // Insertion failed
        }
    }
    public function recentlyAskMethod()
    {
        // Define your SQL query to fetch the last 10 distinct questions with answers provided
        $sql = "SELECT DISTINCT q.*
                FROM questions q
                INNER JOIN answers a ON q.question_id = a.question_id
                ORDER BY q.created_at DESC
                LIMIT 10";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $questions;
    }




    public function MyaskedQuestions($cid)
    {
        $sql = "SELECT * FROM questions WHERE student_id = :student_id ORDER BY created_at";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':student_id', $cid);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $questions;
    }

    public function Get_all_question($tag)
    {
        $sql = "SELECT * FROM questions WHERE question_tag = :tag ORDER BY created_at";

        // Prepare the SQL statement...
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':tag', $tag);

        // Execute the query...
        $stmt->execute();

        // Fetch the data as an associative array...
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $questions;
    }
    public function GetAnswersWithTeacherDetails($questionId)
    {
        $sql = "
            SELECT 
                a.answer_id, 
                a.question_id, 
                a.teacher_id, 
                a.answer_text, 
                a.ratings, 
                a.no_of_ratings, 
                a.created_at, 
                t.name as teacher_name, 
                t.profile_pic as teacher_profile_pic
            FROM 
                answers a
            JOIN 
                teacher_reg t ON a.teacher_id = t.id
            WHERE 
                a.question_id = :questionId
            ORDER BY 
                a.created_at
        ";

        // Prepare the SQL statement...
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':questionId', $questionId);

        // Execute the query...
        $stmt->execute();

        // Fetch the data as an associative array...
        $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $answers;
    }



    public function updateRating($answerId, $rating, $teacherId, $studentId)
    {



        // If the student hasn't rated, proceed with the rating update
        $query = $this->pdo->prepare("INSERT INTO student_ratings (answer_id, student_id, teacher_id, ratings) VALUES (:answerId, :studentId, :teacherId, :rating)");
        $query->bindParam(':answerId', $answerId);
        $query->bindParam(':studentId', $studentId);
        $query->bindParam(':teacherId', $teacherId);
        $query->bindParam(':rating', $rating);
        $query->execute();

        // Update the answer_table
        $updateAnswerQuery = $this->pdo->prepare("UPDATE answers SET ratings = (ratings * no_of_ratings + :rating) / (no_of_ratings + 1), no_of_ratings = no_of_ratings + 1 WHERE answer_id = :answerId");
        $updateAnswerQuery->bindParam(':answerId', $answerId);
        $updateAnswerQuery->bindParam(':rating', $rating);
        $updateAnswerQuery->execute();

        // Update the teacher_reg table
        $updateTeacherRegQuery = $this->pdo->prepare("UPDATE teacher_reg SET overall_ratings = (overall_ratings * no_of_ratings + :rating) / (no_of_ratings + 1), no_of_ratings = no_of_ratings + 1 WHERE id = :teacherId");
        $updateTeacherRegQuery->bindParam(':teacherId', $teacherId);
        $updateTeacherRegQuery->bindParam(':rating', $rating);
        $updateTeacherRegQuery->execute();





        return true; // Success

    }

    public function hasStudentRatedAnswer($answerId, $studentId)
    {
        // Prepare and execute a query to check if the student has rated the answer
        $query = $this->pdo->prepare("SELECT COUNT(*) FROM student_ratings WHERE answer_id = :answerId AND student_id = :studentId");
        $query->bindParam(':answerId', $answerId);
        $query->bindParam(':studentId', $studentId);
        $query->execute();

        // Fetch the result
        $result = $query->fetch(PDO::FETCH_COLUMN);



        // If the count is greater than 0, the student has already rated the answer
        return $result > 0;
    }
    public function change_name_details($name, $id)
    {

        $sql = "update student_reg set name=:name where id=:id ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);


        $stmt->execute();
        return true;
    }

    public function update_new_pass($pass, $email)
    {
        $sql = "update student_reg set password= :pass where email=:email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':pass', $pass);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return true;

    }



    //fetch notification
    public function fetchNotification($uid)
    {
        $sql = "select * from notification where uid=:uid ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uid', $uid);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    //remove notification
    public function removeNotification($id)
    {
        $sql = "delete from notification where id=:id ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return true;
    }

    //show time in ago
    public function timeInAgo($timestamp)
    {
        date_default_timezone_set('Asia/Kolkata');
        $currentTimestamp = time();

        $timestamp = strtotime($timestamp);
        $difference = $currentTimestamp - $timestamp;

        $intervals = array(

            60 => 'min',
            3600 => 'hour',
            86400 => 'day',
            604800 => 'week',
            2592000 => 'month',
            31536000 => 'year'
        );
        if ($difference < 60) {
            $label = 'sec';
            $timeAgo = $difference;
            if ($timeAgo > 1) {
                $label .= 's'; // Pluralize the label if it's more than 1
            }
            return $timeAgo . ' ' . $label . ' ago';
        }
        foreach ($intervals as $seconds => $label) {
            $divisor = $difference / $seconds;
            if ($divisor >= 1) {
                $timeAgo = round($divisor);
                if ($timeAgo > 1) {
                    $label .= 's'; // Pluralize the label if it's more than 1
                }
                return $timeAgo . ' ' . $label . ' ago';
            }
        }
        return 'just now';

    }

    function insertReport($answerId, $teacherId, $studentId, $reportReason)
    {

        $sql = "INSERT INTO report_content (answer_id, teacher_id,student_id, report_reason) 
                VALUES (:answerId, :teacherId,:student_id,:report_reason)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':answerId', $answerId);

        $stmt->bindParam(':teacherId', $teacherId);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':report_reason', $reportReason);

        $stmt->execute();
        return true;
    }
    public function hasStudentReport($answerId, $studentId)
    {
        // Prepare and execute a query to check if the student has rated the answer
        $query = $this->pdo->prepare("SELECT COUNT(*) FROM report_content WHERE answer_id = :answerId AND student_id = :studentId");
        $query->bindParam(':answerId', $answerId);
        $query->bindParam(':studentId', $studentId);
        $query->execute();

        // Fetch the result
        $result = $query->fetch(PDO::FETCH_COLUMN);



        // If the count is greater than 0, the student has already rated the answer
        return $result > 0;
    }


}