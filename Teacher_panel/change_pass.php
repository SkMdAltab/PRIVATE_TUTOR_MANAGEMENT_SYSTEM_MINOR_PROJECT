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
                        <div class="card-header lead text-center bg-primary text-white "><h5>Change Password</h5></div>
                        <div class="card-body">
                            <form  method="post" id="changePassForm" class="px-3 mt-2 ">
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
                                    <input type="password" name="cnewpass" placeholder='confirm new password'
                                        id="cnewpass" class="form-control form-control-lg" required minlength="5">
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


        <?php require_once "body_link.php" ?>
</body>

</html>