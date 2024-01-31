<?php
require_once 'assets/php/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "header_link.php"; ?>
    <style>
        .question-link,
        .question-link:hover {
            display: block;
            text-decoration: none;
            color: #333;
            background-color: #e0e0e0;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        #askedQuestionsContent {
            max-height: 400px;
            /* Set the desired max height for the modal body */
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="main">
        <?php require_once "navbar.php" ?>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <center>
                        <h4 id="heading_user_management" class="mt-2"></h4>
                    </center>
                    <div class="dropdown mt-3">
                        <button class="btn btn-primary dropdown-toggle mb-2" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Select User Type
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a href="#" class="dropdown-item" data-value="teacher">Teachers</a></li>
                            <li><a href="#" class="dropdown-item" data-value="student">Students</a></li>
                        </ul>
                    </div>

                    <div id="student-table" class="user-table">
                        <div class="table-responsive" id="showNote">
                            <!--table start -->

                            <!-- here data table is shown -->

                            <!-- table end -->
                        </div>


                    </div>

                    <div id="teacher-table" class="user-table" style="display: none;">
                        <div class="table-responsive" id="showNoteT">
                            <!--table start -->

                            <!-- here data table is shown -->

                            <!-- table end -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for displaying certificate image -->
        <div class="modal fade" id="certificateModal" tabindex="-1" role="dialog"
            aria-labelledby="certificateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="certificateModalLabel">Certificate Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="" id="certificateImage" class="img-fluid" alt="Certificate Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="panModal" tabindex="-1" role="dialog" aria-labelledby="panModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="panModalLabel">pan Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" id="panImage" class="img-fluid" alt="pan Image">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for displaying asked questions -->
    <div class="modal fade" id="askedQuestionsModal" tabindex="-1" role="dialog"
        aria-labelledby="askedQuestionsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="askedQuestionsModalLabel">Asked Questions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="askedQuestionsContent"></div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <?php require_once "body_link.php" ?>
    <script>

        $(document).ready(function () {
            var defaultUserType = "teacher";

            // Initialize the user type
            selectUserType(defaultUserType);

            // Handle the dropdown item click
            $(".dropdown-menu li a").click(function () {
                var userType = $(this).data("value");
                selectUserType(userType);
            });

            function selectUserType(userType) {
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'POST',
                    data: {
                        action: 'loadUserData',
                        userType: userType
                    },
                    success: function (data) {
                        if (userType === 'student') {
                            $('#student-table').show();
                            $('#teacher-table').hide();
                            $('#heading_user_management').text('Student Data');

                            // Update the student table with the fetched data
                            $("#showNote").html(data);
                            initializeStudentDataTable(); // Initialize student table
                        } else {
                            $('#student-table').hide();
                            $('#teacher-table').show();
                            $('#heading_user_management').text('Teacher Data');
                            $("#showNoteT").html(data);
                            initializeTeacherDataTable(); // Initialize teacher table
                        }
                    }
                });
            }

            // ... rest of your JavaScript code ...

            function initializeStudentDataTable() {
                $("#studentDataTable").DataTable({
                    order: [0, 'desc'],
                    "iDisplayLength": 5,
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            }

            function initializeTeacherDataTable() {
                $("#teacherDataTable").DataTable({
                    order: [0, 'desc'],
                    "iDisplayLength": 5,
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            }


            // Handle the "View Certificate" button click
            $(document).on("click", ".view-certificate", function () {
                var userId = $(this).data("id");
                showCertificateModal(userId);
            });
            $(document).on("click", ".view-pan", function () {
                var userId = $(this).data("id");
                showpanModal(userId);
            });

            //accept certificate
            $(document).on("click", ".accept-button", function () {
                var userId = $(this).data("id");
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'POST',
                    data: {
                        action: 'accept_certificate',
                        userId: userId
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            type: "success",
                            title: 'Verified user',
                            customClass: {
                                confirmButton: 'custom-ok-button-class' // Add your custom class name here
                            }
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }
                });
            });
            $(document).on("click", ".reject-button", function () {
                var userId = $(this).data("id");
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'POST',
                    data: {
                        action: 'reject_certificate',
                        userId: userId
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            type: "success",
                            title: 'Reject Certificate',
                            customClass: {
                                confirmButton: 'custom-ok-button-class' // Add your custom class name here
                            }
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }
                });
            });
            $(document).on("click", ".ban-student-button", function () {
                var userId = $(this).data("id");
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'POST',
                    data: {
                        action: 'ban_student',
                        userId: userId
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            type: "success",
                            title: 'Ban Successful',
                            customClass: {
                                confirmButton: 'custom-ok-button-class' // Add your custom class name here
                            }
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }
                });
            });
            $(document).on("click", ".unban-student-button", function () {
                var userId = $(this).data("id");
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'POST',
                    data: {
                        action: 'unban_student',
                        userId: userId
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            type: "success",
                            title: 'Unban Successful',
                            customClass: {
                                confirmButton: 'custom-ok-button-class' // Add your custom class name here
                            }
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }
                });
            });

            // Function to fetch certificate path and display the modal
            function showCertificateModal(userId) {
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'POST',
                    data: {
                        action: 'getCertificatePath',
                        userId: userId
                    },
                    success: function (data) {
                        // Assuming data is the path to the certificate image
                        var certificatePath = data;

                        // Set the image source in the modal
                        $("#certificateImage").attr("src", certificatePath);

                        // Show the modal
                        $("#certificateModal").modal("show");
                    }
                });
            }
            function showpanModal(userId) {
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'POST',
                    data: {
                        action: 'getpanPath',
                        userId: userId
                    },
                    success: function (data) {
                        // Assuming data is the path to the pan image
                        var panPath = data;

                        // Set the image source in the modal
                        $("#panImage").attr("src", panPath);

                        // Show the modal
                        $("#panModal").modal("show");
                    }
                });
            }

            $(document).on("click", ".view-button", function () {
                var userId = $(this).data("id");
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'POST',
                    data: {
                        action: 'view_all_student_questions',
                        userId: userId
                    },
                    success: function (response) {
                        console.log(response);
                        // Populate the modal with asked questions
                        $("#askedQuestionsContent").html(response);

                        // // Show the modal
                        $("#askedQuestionsModal").modal("show");
                    }
                });

            });

          

        });

    </script>
</body>

</html>