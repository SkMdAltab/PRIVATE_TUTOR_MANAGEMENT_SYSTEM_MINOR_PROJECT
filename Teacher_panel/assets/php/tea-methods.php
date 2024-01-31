<?php
require_once 'tea-connection.php';
class TeaMethods extends Database
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

    //update new password to database
    public function update_new_pass($pass, $email)
    {
        $sql = "update teacher_reg set password= :pass where email=:email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':pass', $pass);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return true;

    }

    //send contact us  message to admin
    public function send_contact_us($name, $email, $message)
    {
        $sql = "insert into contactus(name,email,message) values (:name,:email,:message)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':message', $message);
        if ($stmt->execute()) {

            return true;
        }
        return false;

    }

    public function currentUser($email)
    {
        $sql = "SELECT * FROM teacher_reg WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }


    // public function uploadFile($fileField, $targetDirectory, $allowedExtensions)
    // {
    //     $fileName = $_FILES[$fileField]['name'];
    //     $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    //     if (!in_array($fileExtension, $allowedExtensions)) {
    //         return false; // Invalid file format
    //     }

    //     $targetFile = $targetDirectory . basename($fileName);

    //     if (move_uploaded_file($_FILES[$fileField]['tmp_name'], $targetFile)) {
    //         return $targetFile; // Successful upload
    //     } else {
    //         return false; // File upload failed
    //     }
    // }
    public function uploadFile($fileField, $targetDirectory, $allowedExtensions, $userId)
    {
        $fileName = $_FILES[$fileField]['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        if (!in_array($fileExtension, $allowedExtensions)) {
            return false; // Invalid file format
        }

        $uniqueFileName = $this->generateUniqueFileName($targetDirectory, $fileName);

        $targetFile = $targetDirectory . $uniqueFileName;
        // Check if the old file with the same name exists and delete it
        $oldImageInfo = $this->getUserImageInfo($userId);

        // Delete the old image if it exists
        if ($oldImageInfo) {
            $oldFile = $targetDirectory . $oldImageInfo['file_name'];
            if (file_exists($oldFile)) {
                unlink($oldFile); // Delete the old file
            }
        }

        if (move_uploaded_file($_FILES[$fileField]['tmp_name'], $targetFile)) {
            return $uniqueFileName; // Successful upload, return the unique file name
        } else {
            return false; // File upload failed
        }
    }

    private function generateUniqueFileName($targetDirectory, $fileName)
    {
        $originalFileName = $fileName;
        $counter = 1;

        while (file_exists($targetDirectory . $fileName)) {
            // File with the same name already exists, append a counter to make it unique
            $fileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $counter . '.' . pathinfo($originalFileName, PATHINFO_EXTENSION);
            $counter++;
        }

        return $fileName;
    }
    private function getUserImageInfo($userId)
    {

        $sql = "SELECT profile_pic FROM teacher_reg WHERE id = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['profile_pic'])) {
            return ['file_name' => $result['profile_pic']];
        } else {
            return null;
        }

    }


    public function update_profile_photo($photo, $id)
    {

        $sql = "update teacher_reg set profile_pic=:photo where id=:id ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':photo', $photo);
        $stmt->execute();
        return true;
    }
    public function change_basic_details($name, $about_me, $id)
    {

        $sql = "update teacher_reg set name=:name,about_me=:about_me where id=:id ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':about_me', $about_me);

        $stmt->execute();
        return true;
    }
    public function change_contact_details($phone, $homeaddress, $city, $pin, $id)
    {

        $sql = "update teacher_reg set phone=:phone,Home_address=:Home_address,city=:city,pin=:pin where id=:id ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':Home_address', $homeaddress);
        $stmt->bindValue(':city', $city);
        $stmt->bindValue(':pin', $pin);


        $stmt->execute();
        return true;
    }
    public function is_city_exist($city)
    {
        $sql = "SELECT city FROM location WHERE city = :city";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':city', $city);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return true;
        } else {
            return false;
        }

    }

    //if city is not exist add city to the location table
    public function update_location($city)
    {
        $sql = "insert into location(city) values (:new_city)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':new_city', $city);
        $stmt->execute();

    }
    public function change_subjects($new_sub_arr, $id)
    {

        $sql = "update teacher_reg set subjects=:new_sub where id=:id ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':new_sub', $new_sub_arr);
        $stmt->execute();

        return true;
    }

    public function insert_new_location_subject($city, $new_sub)
    {
        // Check if the new subject already exists for the specified city
        $sql1 = "SELECT location_subjects FROM location WHERE city = :city";
        $stmt1 = $this->pdo->prepare($sql1);
        $stmt1->bindValue(':city', $city);
        $stmt1->execute();
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $location_subjects = explode(',', $result['location_subjects']);
            if (in_array($new_sub, $location_subjects)) {
                return true; // Subject already exists, no need to insert
            } else {
                // Append the new subject to the existing subjects
                $new_location_subjects = $result['location_subjects'] . ',' . $new_sub;
            }
        } else {
            // There are no subjects for this city, set the new subject
            $new_location_subjects = $new_sub;
        }

        // Update the location_subjects column for the specified city
        $sql2 = "UPDATE location SET location_subjects = :new_sub WHERE city = :city";
        $stmt2 = $this->pdo->prepare($sql2);
        $stmt2->bindValue(':new_sub', $new_location_subjects);
        $stmt2->bindValue(':city', $city);
        $stmt2->execute();
    }

    public function toggle_set($teacherid, $status)
    {
        $sql = "UPDATE teacher_reg SET active = :status WHERE id = :teacherId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':teacherId', $teacherid);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }


    }
    public function check_active_status($cid)
    {
        $sql = "SELECT active FROM teacher_reg WHERE id = :teacherId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':teacherId', $cid);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $activeStatus = $result['active'];
            // Return the 'active' status as a response
            return $activeStatus;
        }
    }
    public function get_all_subjects()
    {
        $sql = "SELECT subject_names FROM all_subjects";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    public function get_my_questions($cid, $my_subjects)
    {
        // Generate placeholders for the IN clause based on the number of subjects
        $placeholders = implode(',', array_fill(0, count($my_subjects), '?'));

        // Build the SQL query with the IN clause and include student name
        $sql = "SELECT q.question_tag, q.question_id, q.student_id, s.name AS student_name, q.created_at, q.question_text
                FROM questions q
                JOIN student_reg s ON q.student_id = s.id
                WHERE q.question_tag IN ($placeholders) ORDER BY q.created_at DESC";

        $stmt = $this->pdo->prepare($sql);

        // Bind the values for the placeholders
        foreach ($my_subjects as $index => $subject) {
            $stmt->bindValue($index + 1, $subject); // Index starts from 1
        }

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function insertAnswer($questionID, $answerText, $teacher_id)
    {

        // Insert the new answer into the 'answers' table
        $sql = "INSERT INTO answers (question_id,teacher_id, answer_text) VALUES (:question_id,:teacher_id, :answer_text)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':question_id', $questionID);
        $stmt->bindParam(':teacher_id', $teacher_id);
        $stmt->bindParam(':answer_text', $answerText);
        $stmt->execute();

        // You can also perform additional logic or validations here

        return true; // Indicates success

    }
    // Function to get all answered questions
    public function get_answered_questions($teacher_id)
    {
        $sql = "SELECT q.question_tag, q.question_id, q.student_id, s.name AS student_name, 
                   a.created_at AS answer_created_at, q.question_text, a.answer_id
            FROM questions q
            JOIN answers a ON q.question_id = a.question_id
            JOIN student_reg s ON q.student_id = s.id
            WHERE a.teacher_id = :teacher_id  
            ORDER BY a.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }





    // Function to check if a question is answered by a specific teacher
    public function is_question_answered($question_id, $teacher_id)
    {
        $sql = "SELECT COUNT(*) AS count
                FROM answers
                WHERE question_id = :question_id AND teacher_id = :teacher_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }


    public function get_edit_answer($answerid)
    {

        // Fetch the previous answer from the database based on answer_id
        $sql = "SELECT answer_text FROM answers WHERE answer_id = :answer_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':answer_id', $answerid, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['answer_text'];

    }
    public function notification($uid, $message)
    {
        $sql = "insert into notification(uid,message) values (:uid,:message)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':uid', $uid);

        $stmt->bindValue(':message', $message);
        if ($stmt->execute()) {

            return true;
        }
        return false;
    }

    public function send_teacher_query($subject, $query, $teacher_id)
    {

        // Insert the new answer into the 'answers' table
        $sql = "INSERT INTO contact_with_admin (subject,query, teacher_id) VALUES (:subject,:query, :teacher_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':query', $query);
        $stmt->bindParam(':teacher_id', $teacher_id);
        $stmt->execute();

        // You can also perform additional logic or validations here

        return true; // Indicates success

    }
    public function re_upload_certificate($fileField, $targetDirectory, $allowedExtensions)
    {
        $fileName = $_FILES[$fileField]['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        if (!in_array($fileExtension, $allowedExtensions)) {
            return false; // Invalid file format
        }

        $uniqueFileName = $this->generateUniqueFileName($targetDirectory, $fileName);

        $targetFile = $targetDirectory . $uniqueFileName;

        if (move_uploaded_file($_FILES[$fileField]['tmp_name'], $targetFile)) {
            return $uniqueFileName; // Successful upload, return the unique file name
        } else {
            return false; // File upload failed
        }
    }




    public function update_certifi_pan_path($cid, $cer_path, $pan_path)
    {
        $sql = "UPDATE teacher_reg SET certificate_path = :cer_path, pan_path = :pan_path ,approve_certificate=0 WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $cid);
        $stmt->bindValue(':cer_path', $cer_path);
        $stmt->bindValue(':pan_path', $pan_path);
        $stmt->execute();

        return true;
    }



}