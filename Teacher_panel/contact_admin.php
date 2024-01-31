<?php
require_once 'assets/php/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "headerLink.php"; ?>
</head>

<body>


    <div class="main">
        <?php require_once "navbar.php" ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 mt-3">

                    <div class="card border-primary">
                        <div class="card-header lead text-center bg-primary text-white ">
                            <h5>Contact to Admin</h5>
                        </div>
                        <div class="card-body">
                            <!-- form start -->
                            <form action="#" method="post" class="px-4" id="contact-admin-form">
                                <div class="form-group">
                                    <input type="text" name="subject" placeholder="Write your subject"
                                        class="form-control-lg form-control rounded-1" required>
                                </div>
                                <div class="form-group">
                                    <textarea name="query" placeholder="Write your query here..."
                                        class="form-control-lg form-control rounded-1" rows="8" required></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="feedbackbtn"
                                        class="btn btn-primary btn-block btn-lg rounded-1" value="Send" required>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

            </div>
        </div>



        <?php require_once "body_link.php" ?>
</body>

</html>