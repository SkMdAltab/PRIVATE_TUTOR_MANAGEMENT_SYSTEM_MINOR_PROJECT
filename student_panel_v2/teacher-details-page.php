<?php
require_once 'assets/php/session.php';
require_once 'assets/php/stu-methods.php';
$user_new = new StuMethods();
$teacher_id = $_GET['teacher_id'];
$teacherData = $user_new->getTeacherData($teacher_id);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'header_link.php' ?>
    <style>
        .bg-primary {
  background-color: #6b3ce3 !important;
}
        .teacher-profile-pic {
            width: 250px;
            /* Adjust the image size */
            height: 250px;
            border-radius: 20px;
            margin: 0 auto 2px;
            display: block;
        }

        body {
            background-color: #f0f0f0;

        }


        .footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 50px 0;
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

        .card-style1 {
            box-shadow: 0px 0px 10px 0px rgb(89 75 128 / 9%);
        }

        .border-0 {
            border: 0 !important;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
        }

        section {
            padding: 50px 0;
            overflow: hidden;
            background: #fff;
        }

        .mb-2-3,
        .my-2-3 {
            margin-bottom: 2.3rem;
        }

        .section-title {
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .text-primary {
            color: #ceaa4d !important;
        }

        .text-secondary {
            color: #15395A !important;
        }

        .font-weight-600 {
            font-weight: 600;
        }

        .display-26 {
            font-size: 1.3rem;
        }

        @media screen and (min-width: 992px) {
            .p-lg-7 {
                padding: 4rem;
            }
        }

        @media screen and (min-width: 768px) {
            .p-md-6 {
                padding: 3.5rem;
            }
        }

        @media screen and (min-width: 576px) {
            .p-sm-2-3 {
                padding: 2.3rem;
            }
        }

        .p-1-9 {
            padding: 1.9rem;
        }

        .bg-secondary {
            background: #15395A !important;
        }

        @media screen and (min-width: 576px) {

            .pe-sm-6,
            .px-sm-6 {
                padding-right: 3.5rem;
            }
        }

        @media screen and (min-width: 576px) {

            .ps-sm-6,
            .px-sm-6 {
                padding-left: 3.5rem;
            }
        }

        .pe-1-9,
        .px-1-9 {
            padding-right: 1.9rem;
        }

        .ps-1-9,
        .px-1-9 {
            padding-left: 1.9rem;
        }

        .pb-1-9,
        .py-1-9 {
            padding-bottom: 1.9rem;
        }

        .pt-1-9,
        .py-1-9 {
            padding-top: 1.9rem;
        }

        .mb-1-9,
        .my-1-9 {
            margin-bottom: 1.9rem;
        }

        @media (min-width: 992px) {
            .d-lg-inline-block {
                display: inline-block !important;
            }
        }

        .rounded {
            border-radius: 0.25rem !important;
        }
    </style>
</head>

<body>
    <?php require_once "navbar.php" ?>
    <section class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4 mb-sm-5">
                    <div class="card card-style1 border-0">
                        <div class="card-body p-1-9 p-sm-2-3 p-md-6 p-lg-7">
                            <div class="row align-items-center">
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <img src="../teacher_panel/assets/img/uploads/profile_pic/<?= $teacherData['profile_pic'] ?>"
                                        alt="Teacher's Photo" class="teacher-profile-pic">
                                </div>
                                <div class="col-lg-6 px-xl-10">
                                    <div class="bg-primary d-lg-inline-block py-1-9 px-1-9 px-sm-6 mb-1-9 rounded">
                                        <h3 class="h2 text-white mb-0">
                                            <?php echo $teacherData['name']; ?>
                                        </h3>

                                    </div>
                                    <ul class="list-unstyled mb-1-9">

                                        <li class="mb-2 mb-xl-3 display-28"><span
                                                class="display-26 text-secondary me-2 font-weight-600">Email:</span>
                                            <?php echo $teacherData['email']; ?>
                                        </li>
                                        <li class="mb-2 mb-xl-3 display-28"><span
                                                class="display-26 text-secondary me-2 font-weight-600">Phone:</span>
                                            <?php echo $teacherData['phone']; ?>
                                        </li>
                                        <li class="mb-2 mb-xl-3 display-28"><span
                                                class="display-26 text-secondary me-2 font-weight-600">Home Address:</span>
                                            <?php echo $teacherData['Home_address'] . ', '.$teacherData['city'] . ', ' . $teacherData['pin']; ?>
                                        </li>
                                        <li class="mb-2 mb-xl-3 display-28"><span
                                                class="display-26 text-secondary me-2 font-weight-600">City:</span>
                                            <?php echo $teacherData['city']; ?>
                                        </li>
                                        <li class="display-28"><span
                                                class="display-26 text-secondary me-2 font-weight-600">PIN:</span>
                                            <?php echo $teacherData['pin']; ?>
                                        </li>
                                    </ul>
                                    <ul class="social-icon-style1 list-unstyled mb-0 ps-0">
                                        <!-- Add your social media links here -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-4 mb-sm-5">
                    <div>
                        <span class="section-title text-primary mb-3 mb-sm-4">About Me</span>
                        <p>
                            <?php echo $teacherData['about_me']; ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 mb-4 mb-sm-5">
                            <div>
                                <span class="section-title text-primary mb-3 mb-sm-4">Expertise</span>
                                <p>
                                    <?php echo 'Teaches: ' . $teacherData['subjects']; ?>
                                </p>
                                <p>
                                    <?php echo 'Qualification: ' . $teacherData['latest_qualification']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- BackToTop Button -->
    <a href="javascript:void(0);" id="backToTop" class="back-to-top">
        <i class="arrow"></i><i class="arrow"></i>
    </a>
    <?php require "footer.php"; ?>
    <?php require "body_link.php"; ?>
</body>

</html>