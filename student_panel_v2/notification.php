<?php
require_once 'assets/php/session.php';
require_once 'assets/php/stu-methods.php';








?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'header_link.php' ?>
    <style>
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


        .border-primary {
            border-color: #6b3ce3 !important;
        }
    </style>
</head>

<body>
    <?php require_once "navbar.php" ?>

    <div class="container mt-4 main">
        <div class="row justify-content-center my-2">
            <div class="col-lg-6 mt-4" id="showAllNotification">
                <!-- notification desing will be fetch here from process.php -->
            </div>
        </div>
    </div>


    <?php require "footer.php"; ?>
    <?php require "body_link.php"; ?>
    <script>

        $(document).ready(function () {

            //fetch notification function
            fetchNotification();
            function fetchNotification() {
                $.ajax({
                    url: "assets/php/stu-action.php",
                    method: 'post',
                    data: { action: 'fetchNotification' },
                    success: function (response) {

                        $("#showAllNotification").html(response);

                    }
                });
            }
            // check notification- if there is any new notification the notification icon in nav has red dot
            checkNotification()
            function checkNotification() {
                $.ajax({
                    url: "assets/php/stu-action.php",
                    method: 'post',
                    data: { action: 'checkNotification' },
                    success: function (response) {
                        $("#checkNotification").html(response);
                    }
                });
            }

            //remove notification
            $('body').on('click', '.close', function (event) {
                event.preventDefault();
                notification_id = $(this).attr('id');
                $.ajax({
                    url: "assets/php/stu-action.php",
                    method: 'post',
                    data: { notification_id: notification_id },
                    success: function (response) {
                        checkNotification();
                        fetchNotification();
                    }
                });


            });

        });
    </script>

</body>

</html>