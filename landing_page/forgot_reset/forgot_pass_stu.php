<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
    <?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?>
</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/style_landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container" style="width: 500px;">
        <br>
        <div class="row text-center mt-4">

            <h1>Forgot Your password?</h1>
            <p class="lead text-center text-secondary">To reset your password, enter the registered e-mail adddress and
                we
                will send you password reset instructions on your e-mail!</p>
        </div>
        <br>
        <div class="row justify-content-center border rounded-4 border-2" style="position: relative;">
            <div class="card-footer text-center">
                <a href="javascript:history.back()" class="btn btn-primary position-absolute top-0 end-0  m-2 mb-2">
                    <i class="fa-solid fa-arrow-left"></i></a>
            </div>

            <div class="col-lg-5 d-flex justify-content-center">

                <!-- form start -->
                <form class="forgot-pass" data-user-type="student">
                    <div id="forgotAlert_stu"></div>
                    <br>

                    <div class="mb-3 form-group">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="Type your email" required>
                        <div class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="form-group">
                        <!-- <button type="submit" class="btn btn-primary" style="width: 320px;">Log in</button> -->
                        <input type="submit" id="forgot-btn-stu" class="btn btn-primary " style="width: 320px;"
                            value="Reset password">
                    </div><br><br>
                    <center>
                        <p><a
                                href="../Login_Section/SLogin/Slogin.php">Log
                                in</a></p>
                    </center>

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