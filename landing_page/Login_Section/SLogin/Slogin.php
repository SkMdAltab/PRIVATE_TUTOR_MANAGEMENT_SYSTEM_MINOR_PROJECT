<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (isset($_SESSION['user_student'])) {
    header("Location:http://localhost/prototype_minor_Project/Student_panel_v2/index.php");
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
   Educonn..
</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../assets/css/style_landing.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="container" style="width: 850px;">
    <br>
    <div class="row text-center mt-4">
      <h1>Student Log in</h1>
    </div>
    <br><br><br>
    <div class="row justify-content-center border rounded-4 border-2 position-relative">
    <!-- <button class="btn btn-primary position-absolute top-0 start-0 m-2">Back</button> -->
    <div class="card-footer text-center">
        <a href="javascript:history.back()" class="btn btn-primary position-absolute top-0 end-0  m-2 mb-2">
          <i class="fa-solid fa-arrow-left"></i></a>
      </div>
      <div class="col-md-5 d-flex justify-content-center">
      
        <div class="card mt-4" style="width: 16rem; border: none;">
          <img src="../../../assets/img/login_page_img/student.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h2 class="card-title text-center">I am a Student</h2>
          </div>
        </div>
      </div>
      <div class="col-lg-5 d-flex justify-content-center">
        <!-- form start -->
        <form class="login-form" id="login-form" data-user-type="student">
          <div id="loginAlert"></div>
          <br>
          <div class="mb-3 form-group">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Type your email" required
              value="<?php if (isset($_COOKIE["email"])) {
                echo $_COOKIE['email'];
              } ?>">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3 form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" autocomplete="off" required value="<?php if (isset($_COOKIE["password"])) {
              echo $_COOKIE['password'];
            } ?>">
          </div>
          <div class="mb-3 form-check form-group">
            <input type="checkbox" name="rem" class="form-check-input" id="exampleCheck1" <?php if (isset($_COOKIE["email"])) { ?>checked<?php } ?>>
            <label class="form-check-label" for="exampleCheck1">Remember me</label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../../forgot_reset/forgot_pass_stu.php"
              style="text-decoration: none;">Forgot Password ?</a>
          </div>
          <br>
          <div class="form-group">
            <!-- <button type="submit" class="btn btn-primary" style="width: 320px;">Log in</button> -->
            <input type="submit" name="submit_bt_reg" class="btn btn-primary " style="width: 320px;" value="log in">
          </div>
          <br>
          <center>
            <p>Don't have an account &nbsp;&nbsp;<a
                href="http://localhost/prototype_minor_Project/landing_page/Signup_Section/SSign/ssign.php">Sign Up</a></p>
          </center>
        </form>
      </div>
    </div>
  </div>


  <!-- jQuery CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

  <script src="http://localhost/prototype_minor_Project/assets/js/script.js"></script>


</body>

</html>