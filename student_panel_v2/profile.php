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
        <div class="container mt-5 shadow border-primary" style="border: 2px solid rgb(102, 102, 102); border-radius: 15px;">
            <br>
            <b>Basic Details(userID:<?=$cid?>)</b>
            <form class="row g-3 mt-4 mb-3" id="basic_details_form">
                <div class="col-md-4">
                    <label for="nameInput" class="form-label">Name</label>
                    <input type="text" class="form-control" id="nameInput" name="name" value="<?= $cname ?>" required>
                </div>
                <div class="col-md-12">
                    <label for="emailInput" class="form-label">Email address</label>
                    <input type="email" class="form-control mb-4" id="emailInput" name="email"
                        value="<?= $current_email ?>" readonly required>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn mt-2 btn-primary">Save</button>
                </div>
            </form>
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


            $("#basic_details_form").submit(function (event) {
                event.preventDefault(); // Prevent the default form submission


                $.ajax({
                    url: "assets/php/stu-action.php",
                    method: 'post',
                    data: $('#basic_details_form').serialize() + '&action=basic_details',
                    success: function (response) {


                        if (response == 'true') {

                            Swal.fire({
                                type: "success",
                                title: 'Basic details updated successfully',
                                customClass: {
                                    confirmButton: 'custom-ok-button-class' // Add your custom class name here
                                }
                            }).then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                            });

                        }
                    }
                })

            });
        });
    </script>

</body>

</html>