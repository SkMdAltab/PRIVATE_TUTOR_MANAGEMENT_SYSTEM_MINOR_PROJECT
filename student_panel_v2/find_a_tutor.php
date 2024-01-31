<?php
require_once 'assets/php/session.php';
require_once 'assets/php/stu-methods.php';
$user_new3 = new StuMethods();


$all_subjects = $user_new3->get_all_subjects();
$all_subjects = $all_subjects['subject_names'];
$all_subjects = explode(',', $all_subjects);





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include external CSS and header links -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style_landing.css" />
    <style>
        .teacher-profile-pic {
            width: 100px;
            /* Adjust the image size */
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: block;
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
    </style>
    <!-- Link to your external CSS file -->

    <title>EduConn..</title>
</head>

<body>
    <?php require_once "navbar.php" ?>
    <!-- navbar end -->

    <!-- Dropdown section -->
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-md-3 shadow" style="background-color: #eee8ef; border-radius: 5px 0 0 5px;">
                <h3 class="mt-2">Subject</h3>
                <div class="dropdown-center mb-2">
                    <select id="subject-dropdown" class="btn btn-primary btn-sm dropdown-toggle">
                        <option value="all_subjects">All Subjects</option>
                        <?php foreach ($all_subjects as $subject) { ?>
                            <option value="<?php echo $subject; ?>">
                                <?php echo $subject; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2 " style="background-color: #eee8ef; border-radius: 0 5px 5px 0;">
                <h3 class="mt-2">Location</h3>
                <div class="dropdown-center mb-2">
                    <select id="location-dropdown" class="btn btn-sm btn-primary dropdown-toggle">
                        <option value="all_locations">All Locations</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <br><br> <!-- Create a reusable component for dropdowns -->

    <!-- Reusable card section -->


    <div class="container border rounded-4" style="background-color: #eee;  border-radius:20px;">
        <center>
            <h2>Search Results</h2>
        </center>

        <div class="container py-5 h-100 " id="search_result"
            style="max-height: 700px; overflow-y: scroll;display: none;">
            <div class="row d-flex justify-content-center align-items-center h-100" id="teacher-results">




            </div>
        </div>

    </div>
    <br><br><br><br><br><br>

    <!-- BackToTop Button -->
    <a href="javascript:void(0);" id="backToTop" class="back-to-top">
        <i class="arrow"></i><i class="arrow"></i>
    </a>
    <!-- Footer section -->
    <?php require_once "footer.php" ?>

    <!-- Include JavaScript and jQuery here -->
    <?php require "body_link.php"; ?>
    <script>
        $(document).ready(function () {
            $('#subject-dropdown').change(function () {
                var subject = $(this).val();
                $.ajax({
                    url: 'assets/php/stu-action.php',
                    type: 'POST',
                    data: { action: 'select_subject', subject: subject },
                    dataType: 'json',
                    success: function (response) {
                        var locations = response.locations;
                        var options = '<option value="all_locations">All Locations</option>';
                        for (var i = 0; i < locations.length; i++) {
                            options += '<option value="' + locations[i] + '">' + locations[i] + '</option>';
                        }
                        $('#location-dropdown').html(options);
                    }
                });
            });


            $('#location-dropdown').change(function () {
                var subject = $('#subject-dropdown').val(); // Get the selected subject
                var location = $(this).val(); // Get the selected location
                var searchResults = $('#search_result');
                if (location) {
                    searchResults.show();

                    // Only send the AJAX request if a location is selected
                    $.ajax({
                        url: 'assets/php/stu-action.php', // Change the URL to your action.php file
                        type: 'POST',
                        data: { action: 'get_teachers', subject: subject, location: location },

                        success: function (response) {
                            console.log(response);

                            // Update the search results section with the retrieved teachers
                            // You should have a container for displaying the results, e.g., <div id="teacher-results"></div>
                            $('#teacher-results').html(response);
                        }
                    });
                } else {
                    searchResults.hide();
                }
            });
        });
    </script>
</body>

</html>