<?php
require_once 'connection.php';
class Auth extends Connection
{
    //this showmsg will show msg alert
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

    //Register new student
    public function register_student($name, $email, $password)
    {

        $sql = "INSERT INTO student_reg(name,email,password) VALUES(:name,:email,:password)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        if ($stmt->execute()) {
            return true;
        }
    }


    //Register new teacher
    public function register_teacher($name, $email, $password, $latest_qualification, $certificate_path, $pan_path)
    {

        $sql = "INSERT INTO teacher_reg(name, email, password, latest_qualification,certificate_path, pan_path) VALUES (:name, :email, :password,:latest_qualification ,:certificate_path, :pan_path)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':latest_qualification', $latest_qualification);
        $stmt->bindValue(':certificate_path', $certificate_path);
        $stmt->bindValue(':pan_path', $pan_path);

        if ($stmt->execute()) {
            return true;
        }
    }





    //email already exist or not
    public function user_email_exist($email, $user)
    {
        $emailquery = "";
        if ($user === 'student') {
            $emailquery = "select * from student_reg where email=:email";
        } else {
            $emailquery = "select * from teacher_reg where email=:email";
        }
        $stmt = $this->pdo->prepare($emailquery);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row_count = $stmt->rowCount();
        if ($row_count > 0) {
            return true;
        } else {
            echo false;
        }
    }
    //login registered user
    public function login($email, $user)
    {
        $sql = "";

        if ($user === 'student') {
            $sql = "select email,password from student_reg where email = :email";
        } else {
            $sql = "SELECT email,password FROM teacher_reg WHERE email = :email ";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;

    }

    //current user in Session full details
    public function currentUser($email, $user)
    {
        $sql = "";
        if ($user === "student") {
            $sql = "SELECT * FROM student_reg WHERE email = :email ";

        } else if ($user === 'teacher') {
            $sql = "SELECT * FROM teacher_reg WHERE email = :email ";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;

    }



    // Add this method in your `Auth` class
    public function uploadFile($fileField, $targetDirectory, $allowedExtensions)
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






    //forget password
    public function forgot_passwod($token, $email, $user)
    {
        $sql = "";
        if ($user === "student") {
            $sql = "update student_reg set token= :token, token_expire=DATE_ADD(NOW(),INTERVAL 5 MINUTE) where email=:email";

        } else if ($user === 'teacher') {
            $sql = "update teacher_reg set token= :token, token_expire=DATE_ADD(NOW(),INTERVAL 5 MINUTE) where email=:email";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return true;

    }

    //reset password authentication
    public function reset_pass_auth($email, $token, $user)
    {
        $sql = "";
        if ($user === "student") {
            $sql = "select id from student_reg where email=:email AND token=:token AND token!='' AND token_expire> NOW() ";


        } else if ($user === 'teacher') {
            $sql = "select id from teacher_reg where email=:email AND token=:token AND token!='' AND token_expire> NOW() ";

        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    //update new password to database
    public function update_new_pass($pass, $email, $user)
    {

        $sql = "";
        if ($user === "student") {
            $sql = "update student_reg set token='' ,password= :pass where email=:email";

        } else if ($user === 'teacher') {
            $sql = "update teacher_reg set token='' ,password= :pass where email=:email";
        }
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






}