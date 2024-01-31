<?php
require_once 'assets/php/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "headerLink.php"; ?>

    <style>
        .custom-height {
            height: 38px;
            /* Adjust the height as needed */
            line-height: 1.5;
            /* Adjust the line height as needed */
        }

        .teacher-profile-pic {
            width: 150px;
            /* Adjust the image size */
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 2px;
            display: block;
        }
    </style>

</head>

<body>



    <div class="main">
        <?php require_once "navbar.php" ?>


        <?php if ($approve_certificate == 0) {
            // Display a message for banned teachers
            echo '<div class="alert alert-danger" role="alert">
              Your certificate is not yet verfied!! Wait for verification.
          </div>';
            // Optionally, you may exit the script here to prevent further execution
        
        } else if ($approve_certificate == 2) { ?>

                <div class="alert alert-danger" role="alert">
                    Your certificate is rejected by the admin. Please reupload a new certificate.
                </div>


                <div class="container mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card border-primary shadow">
                                <div class="card-header text-center text-white bg-primary">
                                    <h5><i class="float-left bi bi-file-earmark-text-fill ml-2"></i>Upload New Certificate</h5>
                                </div>
                                <div class="card-body">
                                    <form id="certificateUploadForm" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="certificateInput">Choose Certificate File</label>
                                            <input type="file" class="form-control-file" id="certificateInput"
                                                name="certificate_img_admin" required>
                                            <label for="panInput">Choose Pan File</label>
                                            <input type="file" class="form-control-file" id="panInput" name="pan_img_admin"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php } else { ?>

                <div class="container">
                    <div class="row border mx-2 mt-4 shadow" style="background-color:rgb(232, 227, 237);border-radius: 15px;">
                        <div class="col-md-2 m-3 ">
                            <!-- <img src="assets/img/adm.png" alt="" style="height:150px;"> -->
                        <?php if (!$cphoto): ?>
                                <img src="assets/img/adm.png" alt="" style="height:150px;">

                        <?php else: ?>
                                <img src="<?= '../Teacher_panel/assets/img/uploads/profile_pic/' . $cphoto; ?>"
                                    class="teacher-profile-pic">
                        <?php endif; ?>
                        </div>
                        <div class="col-md-5">
                            <h2 class="mt-5" id="profile_name">
                            <?= $cname ?>
                                <h6>
                                <?php echo "  uid: $cid" ?>
                                </h6>
                            </h2>
                            <div class="btn-group">
                                <form id="profile-photo-form" enctype="multipart/form-data">
                                    <label for="photoInput" class="btn mr-2 btn-primary">
                                        Change Photo
                                    </label>
                                    <input type="file" id="photoInput" name="profile_img" style="display: none;"
                                        accept="image/*">
                                    <input type="hidden" name="oldimage" value="<?= $cphoto; ?>">
                                </form>


                            </div>
                        </div>
                        <!--___________ add toggle button here___ -->
                        <div class="col-md-2 mt-5 ">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="toggleSwitch"
                                    data-teacher-ban="<?= $ban_status ?>">
                                <label class="custom-control-label" for="toggleSwitch" id="toggleLabel">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <!-- -------------------------------------basic details----------------------------------------- -->
                    <div class="container mt-5 shadow" style="background-color:rgb(232, 227, 237); border-radius: 15px;">
                        <br>
                        <b>Basic Details</b>
                        <hr>
                        <form class="row g-3 mt-4 mb-3" id="basic_details_form">
                            <div class="col-md-4">
                                <label for="nameInput" class="form-label">Name</label>
                                <input type="text" class="form-control" id="nameInput" name="name" value="<?= $cname ?>"
                                    required>
                            </div>
                            <div class="col-md-12">
                                <label for="aboutMeInput" class="form-label">About Me</label>
                                <textarea class="form-control" id="aboutMeInput" name="about_me" rows="3"
                                    required><?= $cabout ?></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn mt-2 btn-primary">Save</button>
                            </div>
                        </form>
                    </div>

                    <!-- ___________________________________contact details___________________________________ -->

                    <div class="container  mt-5 shadow" style="background-color:rgb(232, 227, 237); border-radius: 15px;">
                        <br>
                        <b>Contact Details</b>
                        <hr>
                        <form id="contact_details_form" class="row g-3 mt-4 mb-3">
                            <div class="col-md-4">
                                <label for="phoneInput" class="form-label">Phone no.</label>
                                <input type="text" class="form-control mb-4" id="phoneInput" name="phone" value="<?= $cphone ?>"
                                    required>
                            </div>
                            <div class="col-md-12">
                                <label for="emailInput" class="form-label">Email address</label>
                                <input type="email" class="form-control mb-4" id="emailInput" name="email"
                                    value="<?= $current_email ?>" readonly required>
                            </div>
                            <div class="col-md-12">
                                <label for="homeAddressInput" class="form-label">Home address</label>
                                <input type="text" class="form-control" id="homeAddressInput" name="homeAddress"
                                    value="<?= $chome_address ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="cityInput" class="form-label">City</label>
                                <input type="text" class="form-control" id="cityInput" name="city" value="<?= $city ?>"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label for="pinInput" class="form-label">PIN</label>
                                <input type="text" class="form-control mb-5" id="pinInput" name="pin" value="<?= $pin ?>"
                                    required>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn mt-2 btn-primary">Save</button>
                            </div>
                        </form>

                    </div>


                    <!-- ----------------------------------------subjects ------------------------------------>
                    <div class="container mt-5 mb-4 shadow"
                        style="height: 300px; background-color:rgb(232, 227, 237);border-radius: 15px;overflow: auto;">
                        <br>
                        <b>My Subjects</b>
                        <hr>

                        <form action="" id="subject_selection_form">
                            <select name="subject" id="subjects" class="mt-3"
                                style="width: 180px; height: 40px; border-radius: 15px;">
                            <?php foreach ($all_subjects as $subject) { ?>
                                    <option value="<?php echo $subject; ?>">
                                    <?php echo $subject; ?>
                                    </option>
                            <?php } ?>
                            </select>

                            <button type="submit" class="btn btn-primary ml-3" id="addSubject">Add</button>
                        </form>

                        <ul id="subjectList" class="mt-3 pl-3">
                            <?php
                            if (!empty($csubjects)) {
                                foreach ($csubjects as $subject) {
                                    echo "<li>$subject</li>";
                                }
                            }

                            ?>
                        </ul>
                    </div>

                </div>
        <?php } ?>

        <?php require_once "body_link.php"; ?>
        <!-- BackToTop Button -->
        <a href="javascript:void(0);" id="backToTop" class="back-to-top">
            <i class="arrow"></i><i class="arrow"></i>
        </a>
        <script>
            $(document).ready(function () {
                //this for check toggle button status 
                var banStatus = $('#toggleSwitch').data('teacher-ban');
                checkTeacherStatus();
                //end
                $('#photoInput').on('change', function () {
                    // Trigger a custom event if needed
                    $('#profile-photo-form').trigger('fileSelectedEvent');
                });


                $("#profile-photo-form").on('fileSelectedEvent', function (event) {
                    event.preventDefault();
                    var formData = new FormData(this);
                    //formData.append('action', 'register');
                    $.ajax({
                        url: "assets/php/tea-action.php",
                        method: 'post',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        success: function (response) {
                            location.reload();
                        }
                    })

                });

                $("#basic_details_form").submit(function (event) {
                    event.preventDefault(); // Prevent the default form submission


                    $.ajax({
                        url: "assets/php/tea-action.php",
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
                $("#contact_details_form").submit(function (event) {
                    event.preventDefault(); // Prevent the default form submission


                    $.ajax({
                        url: "assets/php/tea-action.php",
                        method: 'post',
                        data: $('#contact_details_form').serialize() + '&action=contact_details',
                        success: function (response) {


                            if (response == 'true') {

                                Swal.fire({
                                    type: "success",
                                    title: 'Contact details updated successfully',
                                    customClass: {
                                        confirmButton: 'custom-ok-button-class' // Add your custom class name here
                                    }
                                })

                            }
                        }
                    })

                });
                $("#subject_selection_form").submit(function (event) {
                    event.preventDefault(); // Prevent the default form submission
                    console.log('hi');


                    $.ajax({
                        url: "assets/php/tea-action.php",
                        method: 'post',
                        data: $('#subject_selection_form').serialize() + '&action=subject_selection',
                        success: function (response) {
                            console.log('hello');
                            console.log(response);

                            if (response == 'true') {

                                Swal.fire({
                                    type: "success",
                                    title: 'Subject Added  successfully',
                                    customClass: {
                                        confirmButton: 'custom-ok-button-class' // Add your custom class name here
                                    }
                                }).then((result) => {
                                    if (result.value) {
                                        location.reload();
                                    }
                                });

                            } else {
                                Swal.fire({
                                    type: "error",
                                    title: 'Subject Already exist!!',
                                    customClass: {
                                        confirmButton: 'custom-ok-button-class' // Add your custom class name here
                                    }
                                })
                            }
                        }
                    })

                });
                //toggle button code start

                $('#toggleSwitch').change(function () {
                    var label = $('#toggleLabel');
                    var banStatus = $(this).data('teacher-ban');


                    if (banStatus === 0) {
                        if ($(this).is(':checked')) {
                            // Toggle switch is ON
                            label.text("Active");
                            updateActiveStatus(1);
                        } else {
                            // Toggle switch is OFF
                            label.text("Inactive");
                            updateActiveStatus(0);
                        }
                    }
                });

                function updateActiveStatus(status) {
                    if (banStatus === 0) {
                        $.ajax({
                            url: 'assets/php/tea-action.php', // Replace with the actual URL of your PHP script
                            method: 'POST',
                            data: { status: status },
                            success: function (response) {
                                // Handle the response from the server if needed
                                console.log(response);

                            }
                        });
                    }
                }

                function checkTeacherStatus() {
                    var label = $('#toggleLabel');
                    if (banStatus === 0) {
                        $.ajax({
                            url: 'assets/php/tea-action.php', // Replace with the actual URL of your PHP script
                            method: 'POST',
                            data: { action: 'check_teacher_status' },
                            success: function (response) {
                                // Update the toggle button based on the response from the server
                                if (response === '1') {
                                    $('#toggleSwitch').prop('checked', true);
                                    $('#toggleLabel').text("Active");
                                } else {
                                    $('#toggleSwitch').prop('checked', false);
                                    $('#toggleLabel').text("Inactive");
                                }
                            }
                        });
                    } else {
                        label.text("Your Id is banned from Admin side");
                        $('#toggleSwitch').prop('disabled', true);
                    }
                }
            });





            var btn = $('#backToTop');
            $(window).on('scroll', function () {
                if ($(window).scrollTop() > 300) {
                    btn.addClass('show');
                } else {
                    btn.removeClass('show');
                }
            });
            btn.on('click', function (e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, '300');
            });

            //re upload certifiate
            $("#certificateUploadForm").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                formData.append('action', 're_upload_certificate');
                //formData.append('action', 'register');
                $.ajax({
                    url: "assets/php/tea-action.php",
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            type: "success",
                            title: 'Upload successfully',
                            customClass: {
                                confirmButton: 'custom-ok-button-class' // Add your custom class name here
                            }
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }
                })

            });


        </script>

</body>

</html>