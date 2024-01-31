<?php
session_start();
include "../../vendor/autoload.php";
require_once 'authentication.php';
require '../../phpMailer/src/Exception.php';
require '../../phpMailer/src/PHPMailer.php';
require '../../phpMailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$user = new Auth();
//handle register ajax request
if (isset($_POST['action']) && $_POST['action'] == 'register' && $_POST['type'] == 'student') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);

    //use composer to validate email -> dns,formating
    $validator = new EmailValidator();
    $multipleValidations = new MultipleValidationWithAnd([
        new RFCValidation(),
        new DNSCheckValidation()
    ]);
    //ietf.org has MX records signaling a server with email capabilities
    $result = $validator->isValid($email, $multipleValidations); // it will return true or false

    if ($result) {
        if ($user->user_email_exist($email, $_POST['type'])) {
            echo $user->showMessage("warning", "This E-mail is already registered!!");
        } else {
            if (isset($_COOKIE['email']) && $email == $_COOKIE['email']) {
                if ($user->register_student($name, $email, $hash_pass)) {
                    setcookie("email", "", 1, '/');
                    echo "register";
                    $_SESSION['user'] = $email;
                    $_SESSION['user_type'] = $_POST['type'];
                    $_SESSION['user_student'] = 'student';
                    $_SESSION['user_stu'] = $email;
                    // it will help in fetch user data using session and user email to get user full data from database
                } else {
                    echo $user->showMessage("danger", "Something went wrong! try again later!");
                }
            } else {
                echo $user->showMessage("danger", "Your email is not verified yet!");
            }


        }
    } else {
        echo $user->showMessage("warning", "This E-mail is invalid");
    }


} else if (isset($_POST['action']) && $_POST['action'] == 'register' && $_POST['type'] == 'teacher') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
    $latest_qualification = filter_var($_POST['latest_qualification'], FILTER_SANITIZE_STRING);

    //use composer to validate email -> dns,formating
    $validator = new EmailValidator();
    $multipleValidations = new MultipleValidationWithAnd([
        new RFCValidation(),
        new DNSCheckValidation()
    ]);
    //ietf.org has MX records signaling a server with email capabilities
    $result = $validator->isValid($email, $multipleValidations); // it will return true or false

    if ($result) {
        if ($user->user_email_exist($email, $_POST['type'])) {
            echo $user->showMessage("warning", "This E-mail is already registered!!");
        } else {
            $allowedExtensions = array('jpg', 'png', 'jpeg');
            $certificate_path = $user->uploadFile('certificate_img', '../../Teacher_panel/assets/img/uploads/certificates/', $allowedExtensions);
            $pan_path = $user->uploadFile('pan_img', '../../Teacher_panel/assets/img/uploads/pan_img/', $allowedExtensions); //pan img is the name of name varible in form input field

            if ($certificate_path && $pan_path) {
                if (isset($_COOKIE['emailT']) && $email == $_COOKIE['emailT']) {
                    if ($user->register_teacher($name, $email, $hash_pass, $latest_qualification, $certificate_path, $pan_path)) {
                        setcookie("email", "", 1, '/');
                        echo "register";

                        $_SESSION['user'] = $email;
                        $_SESSION['user_type'] = $_POST['type'];
                        $_SESSION['user_teacher'] = 'teacher';
                    } else {
                        echo $user->showMessage("danger", "Something went wrong! Try again later!");
                    }
                } else {
                    echo $user->showMessage("danger", "Your email is not verified Yet!");
                }
            } else {
                echo $user->showMessage("warning", "File upload failed. Please upload PNG, JPG, or JPEG images.");
            }
        }
    } else {

        echo $user->showMessage("warning", "This E-mail is invalid");
    }
}

//handle login ajax request
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $loggedInUser = $user->login($email, $_POST['type']);
    if ($loggedInUser != null) {
        if (password_verify($pass, $loggedInUser['password'])) {
            if (!empty($_POST['rem'])) {
                setcookie("email", $email, time() + (30 * 24 * 60 * 60), '/');
                setcookie("password", $pass, time() + (30 * 24 * 60 * 60), '/');
            } else {
                setcookie("email", "", 1, '/');
                setcookie("password", "", 1, '/');
            }
            echo 'login';

            $_SESSION['user_type'] = $_POST['type'];
            if ($_POST['type'] == 'student') {

                $_SESSION['user_student'] = 'student';
                $_SESSION['user_stu'] = $email;
            } else {
                $_SESSION['user_teacher'] = 'teacher';
                $_SESSION['user'] = $email;
            }


        } else {
            echo $user->showMessage("danger", "Passwor is not correct!!");
        }
    } else {
        echo $user->showMessage("danger", "User not found!!");
    }

}




//handle forgot password ajax request

if (isset($_POST['action']) && $_POST['action'] == 'forgot') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $u = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
    $user_found = $user->currentUser($email, $u);
    if ($user_found != null) {

        $token = uniqid();
        $token = str_shuffle($token);
        $user->forgot_passwod($token, $email, $u);


        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP(); //Send using SMTP
            $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
            $mail->SMTPAuth = true; //Enable SMTP authentication
            $mail->Username = 'educonnofficial@gmail.com'; //SMTP username
            $mail->Password = 'ysdvegiezkcptflk'; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
            $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('educonnofficial@gmail.com', 'Educonn..');
            $mail->addAddress($email); //Add a recipient
            //Name is optional


            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //Optional name

            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'Reset Password!';
            if ($u === 'student') {

                $mail->Body = '<h3>Click the below link to reset your password user:Student.<br><a href="http://localhost/prototype_minor_Project/landing_page/forgot_reset/reset_pass_stu.php?email=' . $email . '&token=' . $token . '&type=' . $u . '">Click Me</a><br>Regards<br>Educonn..</h3>';
            } else {

                $mail->Body = '<h3>Click the below link to reset your password usser:Teacher.<br><a href="http://localhost/prototype_minor_Project/landing_page/forgot_reset/reset_pass_tea.php?email=' . $email . '&token=' . $token . '&type=' . $u . '">Click Me</a><br>Regards<br>Educonn..</h3>';
            }
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo $user->showMessage('success', 'We have send you the reset link in your e-mail ID, please check your e-mail!');
        } catch (Exception $e) {
            echo $user->showMessage("danger", "Message could not be sent!!");
        }
    } else {
        echo $user->showMessage('info', "This email is not registered !!");
    }
}




if (isset($_POST['action']) && $_POST['action'] == 'verify_email_stu') {
    $current_email = $_POST['email'];
    $user_type = 'student';


    $validator = new EmailValidator();
    $multipleValidations = new MultipleValidationWithAnd([
        new RFCValidation(),
        new DNSCheckValidation()
    ]);

    $result = $validator->isValid($current_email, $multipleValidations);
    $verification_token = bin2hex(random_bytes(16)); // You can adjust the length of the token as needed


    setcookie('token', $verification_token, time() + 3600, '/', '', false, true);

    try {
        if ($result) {
            $mail->isSMTP(); //Send using SMTP
            $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
            $mail->SMTPAuth = true; //Enable SMTP authentication
            $mail->Username = 'educonnofficial@gmail.com'; //SMTP username
            $mail->Password = 'ysdvegiezkcptflk'; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
            $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('educonnofficial@gmail.com', 'Educonn..');
            $mail->addAddress($current_email); //Add a recipient



            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'Email verification!';
            $verification_link = 'http://localhost/prototype_minor_Project/landing_page/verify_email/verify_stu_email.php?email=' . $current_email . '&token=' . $verification_token . '&user_type=' . $user_type;
            $mail->Body = '<h3>Click the below link to verify your email.<br>This link is valid upto 5min<br><a href="' . $verification_link . '">Click Me</a><br>Regards<br>Educonn..</h3>';

            $mail->send();
            echo $user->showMessage('success', 'We have send you E-mail verification link in your e-mail ID, please check your e-mail!');
        } else {
            echo $user->showMessage("danger", "Message could not be sent ,Please enter valid email address!");
        }

    } catch (Exception $e) {
        echo $user->showMessage("danger", "Message could not be sent ,Mailer Error!");
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'verify_email_tea') {
    $user_type = 'teacher';
    $current_email = $_POST['email'];


    // $_SESSION['verify_email_stu'] = 0;
    $validator = new EmailValidator();
    $multipleValidations = new MultipleValidationWithAnd([
        new RFCValidation(),
        new DNSCheckValidation()
    ]);

    $result = $validator->isValid($current_email, $multipleValidations);


    $verification_token = bin2hex(random_bytes(16)); // You can adjust the length of the token as needed


    setcookie('token', $verification_token, time() + 3600, '/', '', false, true);

    try {
        if ($result) {
            $mail->isSMTP(); //Send using SMTP
            $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
            $mail->SMTPAuth = true; //Enable SMTP authentication
            $mail->Username = 'educonnofficial@gmail.com'; //SMTP username
            $mail->Password = 'ysdvegiezkcptflk'; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
            $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('educonnofficial@gmail.com', 'Educonn..');
            $mail->addAddress($current_email); //Add a recipient



            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'Email verification!';
            $verification_link = 'http://localhost/prototype_minor_Project/landing_page/verify_email/verify_stu_email.php?email=' . $current_email . '&token=' . $verification_token . '&user_type=' . $user_type;
            $mail->Body = '<h3>Click the below link to verify your email.<br>This link is valid upto 5min<br><a href="' . $verification_link . '">Click Me</a><br>Regards<br>Educonn..</h3>';
            $mail->send();
            echo $user->showMessage('success', 'We have send you E-mail verification link in your e-mail ID, please check your e-mail!');
        } else {
            echo $user->showMessage("danger", "Message could not be sent ,Please enter valid email address!");
        }
    } catch (Exception $e) {
        echo $user->showMessage("danger", "Message could not be sent , Please Enter valid email!");
    }
}


//handle feedback to admin ajax request
if (isset($_POST['action']) && $_POST['action'] == 'contact_us') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    if ($user->send_contact_us($name, $email, $message)) {
        echo "feedback send successfully";
    } else {
        echo "unsuccessfull";
    }
}



?>