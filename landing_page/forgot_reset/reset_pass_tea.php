<?php
require_once '../../assets/php/authentication.php';
$user = new Auth();
$msg = '';
if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = filter_var($_GET['email'], FILTER_SANITIZE_STRING);
    $token = filter_var($_GET['token'], FILTER_SANITIZE_STRING);
    $u = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
    $auth_user = $user->reset_pass_auth($email, $token, $u);
    if ($auth_user != null) {
        if (isset($_POST['reset_btn'])) {
            $newpass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
            $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
            $hash_pass = password_hash($newpass, PASSWORD_DEFAULT);
            if ($newpass == $cpass) {
                $user->update_new_pass($hash_pass, $email, $u);
                $msg = "password changed successfully!<br> <a href='http://localhost/prototype_minor_Project/landing_page/Login_Section/TLogin/Tlogin.php'>Login here!</a>";

            } else {
                $msg = "password did not matched!";
            }
        }
    } else {
        header('../location:index.php');
        exit();
    }
} else {
    header('location:../index.php');
    exit();
}

?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset passwordT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/style_landing.css">
</head>

<body>
    <div class="container" style="width: 500px;">
        <br>
        <div class="row text-center mt-4">
            <h1>Reset Password</h1>
        </div>
        <br><br><br>
        <div class="row justify-content-center border rounded-4 border-2">
            <div class="col-lg-5 d-flex justify-content-center">
                <!-- form start -->
                <form class="reset-pass" method="post" data-user-type="teacher">
                    <div class="text-center lead mb-2">
                        <?= $msg ?>
                    </div>
                    <br>
                    <div class="mb-3 form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="pass" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="cpass" class="form-control" autocomplete="off" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <!-- <button type="submit" class="btn btn-primary" style="width: 320px;">Log in</button> -->
                        <input type="submit" name="reset_btn" id="reset_btn_tea" class="btn btn-primary "
                            style="width: 320px;" value="Reset password">
                    </div>
                    <br>

                </form>
            </div>
        </div>
    </div>


    <!-- jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

    <script src="../../assets/js/script.js"></script>


</body>

</html>