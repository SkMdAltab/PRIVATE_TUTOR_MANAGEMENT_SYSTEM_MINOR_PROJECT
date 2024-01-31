$(function () {
    $("#contact_us_form").submit(function (event) {
        event.preventDefault();
        // $("#feedbackbtn").val("Please wait.....");

        $.ajax({
            url: "../assets/php/action.php",
            method: 'post',
            data: $('#contact_us_form').serialize() + '&action=contact_us',
            success: function (response) {
                $('#contact_us_form')[0].reset();
                console.log(response);

                // sweet alert
                Swal.fire({
                    type: "success",
                    title: 'Your feedback reach us',
                    showConfirmButton: true,
                    confirmButtonColor: '#6b3ce3', // Replace with your website's primary color
                    confirmButtonText: 'OK',
                })
            }
        });
    });


    //for page trasition effect
    $(".nav-link").on("click", function (e) {
        e.preventDefault();

        const href = $(this).attr("href");

        if (href.startsWith('#')) {
            // Smoothly scroll to the target section
            $("html, body").animate({
                scrollTop: $(href).offset().top
            }, 200);
        } else {
            // Apply a fade-out animation and redirect to the specified page


            window.location.href = href;
            // Adjust the duration based on your preference
        }
    });
    $(".footer-link").on("click", function (e) {
        e.preventDefault();

        const href = $(this).attr("href");

        if (href.startsWith('#')) {
            // Smoothly scroll to the target section
            $("html, body").animate({
                scrollTop: $(href).offset().top
            }, 200);
        } else {
            // Apply a fade-out animation and redirect to the specified page


            window.location.href = href;
        } // Adjust the duration based on your preference

    });

    // ajax registration request
    $("#register-form-student").submit(function (event) {
        // Your registration form handling logic here
        event.preventDefault();
        console.log("Form submit prevented.");
        var userType = $(this).data("user-type"); // Get the user type from the data attribute

        if ($('#password').val() !== $('#cpassword').val()) {
            $("#passError").text("* Password did not match!");
        } else {
            $("#passError").text("");
            $.ajax({
                url: "../../../assets/php/action.php",
                method: 'post',
                data: $("#register-form-student").serialize() + '&action=register&type=' + userType,
                success: function (response) {
                    if (response === 'register') {
                        // Redirect to the appropriate dashboard after successful registration
                        console.log("reg stu successful.");
                        window.location = '../../../student_panel_v2/index.php';

                    } else {
                        $("#regAlert").html(response);
                    }
                }
            });
        }
    });
    $("#register-form-teacher").submit(function (event) {
        // Your registration form handling logic here
        event.preventDefault();
        // console.log("Form submit prevented.");
        var userType = $(this).data("user-type"); // Get the user type from the data attribute

        if ($('#passwordT').val() !== $('#cpasswordT').val()) {
            $("#passErrorT").text("* Password did not match!");
        } else {
            $("#passErrorT").text("");
            var formData = new FormData(this); // Create a FormData object from the form
            formData.append('action', 'register'); // Add 'action' field to the FormData
            formData.append('type', userType); // Add 'type' field to the FormData
            $.ajax({
                url: "../../../assets/php/action.php",
                method: 'post',
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                success: function (response) {
                    if (response === 'register') {
                        // Redirect to the appropriate dashboard after successful registration

                        window.location = '../../../Teacher_panel/dashboard.php';

                    } else {
                        $("#regAlertT").html(response);
                    }
                }
            });
        }
    });



    // ajax login request
    $(".login-form").submit(function (event) {
        event.preventDefault();

        var userType = $(this).data("user-type"); // Get the user type from the data attribute

        $.ajax({
            url: "../../../assets/php/action.php",
            method: 'post',
            data: $(".login-form").serialize() + '&action=login&type=' + userType,
            success: function (response) {
                if (response === "login") {
                    // Redirect to the appropriate dashboard after successful login
                    if (userType === "student") {
                        window.location = '../../../student_panel_v2/index.php';
                    } else if (userType === "teacher") {
                        window.location = '../../../Teacher_panel/dashboard.php';
                    }
                } else {
                    $("#loginAlert").html(response);
                }
            }
        });
    });






    $(".forgot-pass").submit(function (event) {
        event.preventDefault();
        var userType = $(this).data("user-type");
        if (userType === 'student') {
            console.log(userType);
            $("#forgot-btn-stu").val("Please wait.....");
        } else {
            $("#forgot-btn-tea").val("Please wait.....");
        }

        $.ajax({
            url: "../../assets/php/action.php",
            method: 'post',
            data: $('.forgot-pass').serialize() + '&action=forgot&type=' + userType,
            success: function (response) {
                if (userType === 'student') {
                    console.log(userType, "hello student");
                    $("#forgot-btn-stu").val("Reset Password");
                    $("#forgotAlert_stu").html(response);
                } else {
                    console.log(userType, 'hello teacher');
                    $("#forgot-btn-tea").val("Reset Password.");
                    $("#forgotAlert_tea").html(response);
                }

            }
        });
    });
    // student verify email button work
    // Initially hide the "Verify Your Email" button
    $('#verify-email-stu').hide();

    // Detect changes in the email input
    $('#email').on('input', function () {
        if ($(this).val().trim() !== '') {
            $('#verify-email-stu').show();
            $('#verify-email-stu').text('Verify Your Email');
        } else {
            $('#verify-email-stu').hide();
        }
    });

    $('#verify-email-stu').click(function (event) {
        event.preventDefault();
        var verifyButton = $(this);

        // Get the email input value
        var email = $('#email').val();

        verifyButton.text('Please wait....');

        $.ajax({
            url: "../../../assets/php/action.php",
            method: 'post',
            data: {
                action: 'verify_email_stu',
                email: email
            },
            success: function (response) {
                $("#verifyEmailAlert").html(response);

                // Hide the "Verify Your Email" button again
                verifyButton.hide();
            }
        });
    });


    //teacher verify email button work
    $('#verify-email-tea').hide();

    // Detect changes in the email input
    $('#emailT').on('input', function () {
        if ($(this).val().trim() !== '') {
            $('#verify-email-tea').show();
            $('#verify-email-tea').text('Verify Your Email');
        } else {
            $('#verify-email-tea').hide();
        }
    });

    $('#verify-email-tea').click(function (event) {
        event.preventDefault();
        var verifyButton = $(this);

        // Get the email input value
        var email = $('#emailT').val();

        verifyButton.text('Please wait....');

        $.ajax({
            url: "../../../assets/php/action.php",
            method: 'post',
            data: {
                action: 'verify_email_tea',
                email: email
            },
            success: function (response) {
                $("#verifyEmailAlertTea").html(response);

                // Hide the "Verify Your Email" button again
                verifyButton.hide();
            }
        });
    });




    //scrol back to top button
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



    var currentURL = window.location.href;

    // Check the URL to determine the active link
    if (currentURL.includes("index.php")) {
        $("#home_nav").addClass("link-active");
    } else if (currentURL.includes("find_a_tutor.php")) {
        $("#find_tutor_nav").addClass("link-active");
    } else if (currentURL.includes("profile.php")) {
        $("#profile-link").addClass("link-active");
    } else if (currentURL.includes("contact_admin.php")) {
        $("#contact-admin-link").addClass("link-active");
    } else if (currentURL.includes("changePassword.php")) {
        $("#changePassword-link").addClass("link-active");
    } else if (currentURL.includes("find_a_tutor_landing.php")) {
        $("#find_tutor_nav_landing").addClass("link-active");
    }


});





















