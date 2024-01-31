<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
  Educonn..
</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../assets/css/style_landing.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class='signup-body'>
  <div class="container">

    <div class="row mt-4">
      <center>
        <h1>Student Registration</h1>
      </center>
    </div>
    <br>
    <div class="row">
      <div id="verifyEmailAlert"></div>
      <form class="border rounded-3 blur-form" id="register-form-student" data-user-type="student"
        style="max-width: 600px; margin: 0 auto ;">
        <div id="regAlert"></div>
        <div class="mb-3 mt-2 form-group">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" required>
        </div>
        <div class=" mb-3 form-group">

          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required>

          <!-- <a href="#" id="verify-email-stu" class="float-right">Verify Now</a> -->


        </div>
        <div class="mb-3 form-group">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <div class="mb-3 form-group">
          <label for="cpassword" class="form-label">Confirm Password</label>
          <input type="password" name="cpassword" class="form-control" id="cpassword" required>
        </div>
        <div class="form-group">
          <div id="passError" class="text-danger font-weight-bolder"></div>
        </div>
        <div class="form-group d-flex justify-content-between align-items-center">
          <input type="submit" name="submit_bt_reg_student" class="btn btn-primary mb-2" style="font-weight: bold;"
            value="Sign Up">
          <button type="button" id="verify-email-stu" class="btn btn-primary mx-2 mb-2">Verify Your Email</button>
          <a href="javascript:history.back()" class="btn btn-primary mb-2">
          <i class="fa-solid fa-arrow-left"></i> Back
          </a>
        </div>


      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

  <!-- jQuery CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <script src="../../../assets/js/script.js"></script>


</body>

</html>