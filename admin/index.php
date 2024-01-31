<?php
session_start();
if (isset($_SESSION['user_admin'])) {
    header('location:admin-dashboard.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body::before {
            content: "";
            background: linear-gradient(#3ac086, #116a3f);
            filter: blur(5px);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;

        }
    </style>
</head>

<body style="border: 1px solid #ccc; display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="container">
        <div class="row text-center">
            <h1>Admin login</h1>
        </div>

        <div class="row justify-content-center mt-4 ">
            <div class="col-lg-5"
                style="background-color: #83ceb7; padding: 20px; border: 1px solid #ddd; border-radius:15px;">
                <!-- form start -->
                <form class="login-form blur-form" id="admin-login-form">
                    <div id="adminloginAlert"></div>
                    <div class="mb-3 form-group">
                        <label for="adminName" class="form-label">User Name</label>
                        <input type="text" class="form-control" name="username" id="adminName" placeholder="username"
                            required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" placeholder="password" name="password" class="form-control" id="password"
                            autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="admin_login" id="adminLoginBtn" class="btn btn-primary"
                            style="width: 100%;" value="Log in">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {

            $("#admin-login-form").submit(function (event) {
                event.preventDefault();

                $.ajax({
                    url: "assets/php/admin-action.php",
                    method: 'post',
                    data: $('#admin-login-form').serialize() + '&action=adminlogin',
                    success: function (response) {

                        if (response === "admin_login") {

                            window.location = 'admin-dashboard.php';
                        } else {
                            $("#adminloginAlert").html(response);
                        }
                    }
                });
            });

        });


    </script>
</body>

</html>