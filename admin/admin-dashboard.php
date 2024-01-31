<?php
require_once 'assets/php/session.php';
require_once 'assets/php/authentication.php';
$admin_dash = new Admin();
$student_count=$admin_dash->view_dash_total_student();
$teacher_count=$admin_dash->view_dash_total_teacher();
$active_teacher_count=$admin_dash->view_dash_total_active_teacher();
$pending_req=$admin_dash->dash_pending_request();
$total_reg=$student_count+$teacher_count;
$report_con=$admin_dash->dash_reported_con();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "header_link.php"; ?>
</head>

<body>
    <div class="main">
        <?php require_once "navbar.php" ?>

        <div class="container-fluid">
            <div class="row">

                <!-- Dashboard Box 1 -->
                <div class="col-lg-4 col-md-6 col-sm-12 p-4 mt-4">
                    <div class="card rounded-4 shadow" style="width: 100%;">
                        <div class="card-header rounded-0 bg-primary">
                            <h4 class="card-title text-white mb-1">Total Registered User<i
                                    class="fas fa-users float-right"></i></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="display-4 font-weight-bold text-center mt-4" style="color: #26725e;"><?=$total_reg?>
                            </h1>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Box 2 -->
                <div class="col-lg-4 col-md-6 col-sm-12 p-4 mt-4">
                    <div class="card rounded-4 shadow" style="width: 100%;">
                        <div class="card-header rounded-0 bg-primary">
                            <h4 class="card-title text-white mb-1">Total Student<i
                                    class="fas fa-user-graduate float-right"></i></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="display-4 font-weight-bold text-center mt-4" style="color:#26725e;"><?=$student_count?>
                            </h1>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Box 3 -->
                <div class="col-lg-4 col-md-6 col-sm-12 p-4 mt-4">
                    <div class="card rounded-4 shadow" style="width: 100%;">
                        <div class="card-header rounded-0 bg-primary">
                            <h4 class="card-title text-white mb-1">Total Teacher<i
                                    class="fas fa-chalkboard-teacher float-right"></i>
                            </h4>
                        </div>
                        <div class="card-body">
                            <h1 class="display-4 font-weight-bold text-center mt-4" style="color: #26725e;"> <?=$teacher_count?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 p-4 mt-4">
                    <div class="card rounded-4 shadow" style="width: 100%;">
                        <div class="card-header rounded-0 bg-primary">
                            <h4 class="card-title text-white mb-1">Active Teacher<i
                                    class="fas fa-toggle-on float-right"></i></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="display-4 font-weight-bold text-center mt-4" style="color: #26725e;"><?=$active_teacher_count?>
                            </h1>
                        </div>
                    </div>
                </div>
                <!-- new Dashboard -->
                <div class="col-lg-4 col-md-6 col-sm-12 p-4 mt-4">
                    <div class="card rounded-4 shadow" style="width: 100%;">
                        <div class="card-header rounded-0 bg-primary">
                            <h5 class="card-title text-white mb-1">Pending Approval Request</h5>
                        </div>
                        <div class="card-body">
                            <h1 class="display-4 font-weight-bold text-center mt-4" style="color:#26725e;"><?=$pending_req?>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 p-4 mt-4">
                    <div class="card rounded-4 shadow" style="width: 100%;">
                        <div class="card-header rounded-0 bg-primary">
                            <h4 class="card-title text-white mb-1">Reported Content<i
                                    class="far fa-flag float-right"></i>
                            </h4>
                        </div>
                        <div class="card-body">
                            <h1 class="display-4 font-weight-bold text-center mt-4" style="color:#26725e;"><?=$report_con?>
                            </h1>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <?php require_once "body_link.php" ?>
</body>

</html>