<?php
require_once "connection.php";

class Admin extends Connection
{
    //admin login
    public function admin_login($username, $password)
    {
        $sql = "SELECT username,password FROM admin WHERE username = :username and password= :password";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function getStudentData()
    {
        $sql = "SELECT id, name, email FROM student_reg";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    public function getTeacherData()
    {
        // Replace this with your actual database query to fetch teacher data
        $sql = "SELECT id, name, email, latest_qualification FROM teacher_reg where approve_certificate=0";
        // Execute the query and fetch data
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $teachers;
    }
    public function getCertificatePath($userId)
    {
        // Replace this with your actual database query to fetch the certificate path
        $sql = "SELECT certificate_path FROM teacher_reg WHERE id = :userId";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);



        // Check if the result is not empty and return the certificate path
        if ($result) {
            return $result['certificate_path'];
        }
    }
    public function getPanPath($userId)
    {
        // Replace this with your actual database query to fetch the certificate path
        $sql = "SELECT pan_path FROM teacher_reg WHERE id = :userId";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);



        // Check if the result is not empty and return the certificate path
        if ($result) {
            return $result['pan_path'];
        }
    }


    public function accept_certificate($uid)
    {
        $sql = "UPDATE teacher_reg SET approve_certificate = 1 WHERE id = :uid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
    public function reject_certificate($uid)
    {
        $sql = "UPDATE teacher_reg SET approve_certificate = 2 WHERE id = :uid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
    public function ban_student($uid)
    {
        $sql = "UPDATE student_reg SET ban_status = 1 WHERE id = :uid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
    public function ban_teacher($uid)
    {
        $sql = "UPDATE teacher_reg SET ban_status = 1,active=0 WHERE id = :uid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
    public function unban_student($uid)
    {
        $sql = "UPDATE student_reg SET ban_status = 0 WHERE id = :uid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
    public function unban_teacher($uid)
    {
        $sql = "UPDATE teacher_reg SET ban_status = 0 WHERE id = :uid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }


    public function MyaskedQuestions($cid)
    {
        $sql = "SELECT question_text FROM questions WHERE student_id = :student_id ORDER BY created_at";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':student_id', $cid);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $questions;
    }
    public function view_reported_content()
    {
        $sql = "SELECT * FROM report_content ";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $content = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $content;
    }
    public function view_dash_total_student()
    {
        $sql = "SELECT COUNT(*) as total_students FROM student_reg";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the total number of students
        return $result['total_students'];
    }
    public function view_dash_total_teacher()
    {
        $sql = "SELECT COUNT(*) as total_tea FROM teacher_reg";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the total number of students
        return $result['total_tea'];
    }
    public function view_dash_total_active_teacher()
    {
        $sql = "SELECT COUNT(*) as total_tea FROM teacher_reg where active=1";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the total number of students
        return $result['total_tea'];
    }
    public function dash_pending_request()
    {
        $sql = "SELECT COUNT(*) as total_tea FROM teacher_reg where approve_certificate=0";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the total number of students
        return $result['total_tea'];
    }
    public function dash_reported_con()
    {
        $sql = "SELECT COUNT(*) as total_tea FROM report_content";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the total number of students
        return $result['total_tea'];
    }


    public function view_teacher_query()
    {
        $sql = "SELECT * FROM contact_with_admin ";

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch the data as an associative array
        $content = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $content;
    }
    public function query_resolve($id){
       
            $sql = "delete from contact_with_admin where id=:id ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            return true;
        
    
    }



}

?>