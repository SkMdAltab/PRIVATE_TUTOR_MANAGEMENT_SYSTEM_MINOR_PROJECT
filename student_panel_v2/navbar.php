<div class="header">
    <nav class="navbar shadow navbar-expand-lg navbar-light " style=" background-color: #f4e3ff;">
        <a class="navbar-brand" href="#"><img src="../assets/img/landing_page_img/educonnLogov1.png" alt="Your Logo"
                height="30"></a>
        <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mx-auto" id="navbarNav">
            <ul class="navbar-nav text-center   mx-auto">
                <li class="nav-item ">
                    <a class="nav-link mb-2 " id="home_nav" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 " id="find_tutor_nav" href="find_a_tutor.php">Find a Tutor</a>
                </li>
            </ul>
            <form class="form-inline  mx-auto" id="search_question_all">
                <div class="input-group ">
                    <label class="mb-2" for="subjectSelect">Search Questions &nbsp;</label>
                    <div class="input-group-append">
                        <select class="custom-select" id="subjectSelect_search" name="subject">
                            <?php foreach ($all_subjects as $subject) { ?>
                                <option value="<?php echo $subject; ?>">
                                    <?php echo $subject; ?>
                                </option>
                            <?php } ?>
                            <!-- Add more subjects as needed -->
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary  col-12 col-md-auto text-center   mx-2" type="submit">Search</button>
            </form>
            <ul class="navbar-nav text-center mx-auto">

                <li class="nav-item">
                    <a class="nav-link mb-2 " href="my_questions.php">My Questions</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="../assets/img/landing_page_img/adm.png" height="20px" alt="Profile Icon">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <a class="dropdown-item" href="change_pass.php">Change Password</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Sign Out</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="notification.php">
                        <i class="fas fa-bell"></i> <span id="checkNotification"></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>