<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include external CSS and header links -->
    <?php require_once "header_links.php" ?>
    <!-- Link to your external CSS file -->

    <title>EduConnect</title>
</head>

<body>
    <div class="header">
        <nav class="navbar navbar-light navbar-expand-lg">
            <div class="container-fluid">

                <!-- brand logo  -->

                <img class="navbar-brand" src="../assets/img/landing_page_img/educonnB.png" alt="brand logo"
                    height="80">

                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mynav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mynav">
                    <ul class="navbar-nav text-center ms-auto">

                        <!-- nav items  -->

                        <li class="nav-item p-3"><a href="index.php" class="nav-link">Home</a></li>
                        <li class="nav-item p-3"><a href="find_a_tutor_landing.php" id="find_tutor_nav_landing"
                                class="nav-link">Find a tutor</a>
                        </li>
                        <li class="nav-item p-3"><a href="index.php#io" class="nav-link">About</a></li>
                        <li class="nav-item p-3"><a href="index.php#wt" class="nav-link">Why Choose Us</a></li>
                        <li class="nav-item p-3"><a href="index.php#ct" class="nav-link">Contact us</a></li>
                        <!-- <li class="nav-item"><a href="#" class="nav-link active"></a></li> -->
                    </ul>
                    <ul class="navbar-nav text-center ms-auto">
                        <li class="nav-item p-1">
                            <a href="Signup_Section/sign.php" class="btn btn-primary rounded-pill text-white">Sign
                                up</a>
                        </li>
                        <li class="nav-item p-1">
                            <a href="Login_Section/login.php" class="btn btn-primary rounded-pill text-white">Log in</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>

    </div>
    <!-- navbar end -->

    <div class="container">
        <div class="row text-center">
            <h1 class="page-title">Private tutors that fit you best</h1>
        </div>
    </div>

    <!-- Dropdown section -->
    <?php require_once "dropdowns.php" ?>
    <br><br> <!-- Create a reusable component for dropdowns -->

    <!-- Reusable card section -->
    <?php
    // Define tutor information as an array
    $tutorInfo = array(
        array(
            "image" => "../assets/img/landing_page_img/adm.png",
            "name" => "Tutor Name 1",
            "school" => "School Name 1",
            "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti quibusdam quam in temporibus perspiciatis eum adipisci necessitatibus iusto possimus obcaecati, blanditiis incidunt neque eveniet."
        ),
        array(
            "image" => "../assets/img/landing_page_img/adm.png",
            "name" => "Tutor Name 2",
            "school" => "School Name 2",
            "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti quibusdam quam in temporibus perspiciatis eum adipisci necessitatibus iusto possimus obcaecati, blanditiis incidunt neque eveniet.Another tutor's description goes here."
        ),
        // Add more tutor information as needed
    );
    ?>

    <div class="container border rounded-4">
        <?php foreach ($tutorInfo as $tutor): ?>
            <div class="row justify-content-center mt-3 mb-3">
                <div class="col-md-2 rounded-start-4 d-flex justify-content-center" style="background-color: #f6f6f6;">
                    <img class="mt-3" src="<?php echo $tutor['image']; ?>" alt="" style="height:130px;">
                </div>
                <div class="col-md-5 rounded-end-4" style="background-color: #f6f6f6;">
                    <h2>
                        <?php echo $tutor['name']; ?>
                    </h2>
                    <?php echo $tutor['school']; ?>
                    <br><br>
                    <?php echo $tutor['description']; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <!-- BackToTop Button -->
    <a href="javascript:void(0);" id="backToTop" class="back-to-top">
        <i class="arrow"></i><i class="arrow"></i>
    </a>
    <!-- Footer section -->
    <?php require_once "footer.php" ?>

    <!-- Include JavaScript and jQuery here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>