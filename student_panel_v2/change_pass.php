<?php
require_once 'assets/php/session.php';
require_once 'assets/php/stu-methods.php';








?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'header_link.php' ?>
    <style>
        .bg-primary {
            background-color: #6b3ce3 !important;
        }

        .border-primary {
            border-color: #6b3ce3 !important;
        }

        .custom-ok-button-class {
            background-color: #6b3ce3 !important;

            /*sweet alertok button colot*/
        }

        body {
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main {
            flex: 1;
        }

        .footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 50px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }


        .footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }

        .copyright {
            margin-top: 10px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <?php require_once "navbar.php" ?>

    <div class="container mt-4 main">
        <div class="row justify-content-center">
            <div class="col-lg-8 mt-3">

                <div class="card border-primary">
                    <div class="card-header lead text-center bg-primary text-white ">
                        <h5>Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" id="changePassForm" class="px-3 mt-2 ">
                            <div class="form-group">
                                <label for="curpass">Enter Your current Password</label>
                                <input type="password" name="curpass" placeholder='Current password' id="curpass"
                                    class="form-control form-control-lg" required minlength="5">
                            </div>
                            <div class="form-group">
                                <label for="newpass">Enter Your New Password</label>
                                <input type="password" name="newpass" placeholder='New password' id="newpass"
                                    class="form-control form-control-lg" required>
                            </div>
                            <div class="form-group">
                                <label for="cnewpass">Confirm New Password</label>
                                <input type="password" name="cnewpass" placeholder='confirm new password' id="cnewpass"
                                    class="form-control form-control-lg" required minlength="5">
                            </div>
                            <div class="form-group">
                                <div id="userPassError" class="text-danger font-weight-bolder"></div>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="changePassBtn" id="changePassBtn"
                                    class="btn btn-primary btn-block btn-lg" value="Change Password">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BackToTop Button -->
    <a href="javascript:void(0);" id="backToTop" class="back-to-top">
        <i class="arrow"></i><i class="arrow"></i>
    </a>
    <?php require "footer.php"; ?>
    <?php require "body_link.php"; ?>
    <script>

        $(document).ready(function () {

            $("#changePassForm").submit(function (event) {
                event.preventDefault(); // Prevent the default form submission

                if ($('#newpass').val() !== $('#cnewpass').val()) {
                    $("#userPassError").text("*confirm Password did not matched !");

                } else {
                    $("#userPassError").text("");
                    $.ajax({
                        url: "assets/php/stu-action.php",
                        method: 'post',
                        data: $('#changePassForm').serialize() + '&action=changePass',
                        success: function (response) {

                            console.log(response, 1);
                            if (response == 'true') {
                                $('#changePassForm')[0].reset();
                                Swal.fire({
                                    type: "success",
                                    title: 'Password updated successfully',
                                    customClass: {
                                        confirmButton: 'custom-ok-button-class' // Add your custom class name here
                                    }
                                })

                            } else {
                                $("#userPassError").text("* Current password did not matched !");

                            }
                        }
                    })
                }
            });

        });
    </script>

</body>

</html>