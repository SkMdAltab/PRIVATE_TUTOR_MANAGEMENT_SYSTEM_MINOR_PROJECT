<?php
require_once 'assets/php/session.php';
require_once 'assets/php/stu-methods.php';





if($ban_status==0){
    $teachers = $stu_user->get_best_teacher();

    // Sample data for recently asked questions
    $recentQuestions = $stu_user->recentlyAskMethod();
    
    
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'header_link.php' ?>
    <style>
        .custom-ok-button-class {
            background-color: #6b3ce3 !important;

            /*sweet alertok button colot*/
        }

        body {
            /* background-color: #f0f0f0; */
            background-color: #f0f0f0;
        }

        .qa-container {
            display: flex;
            justify-content: space-between;

        }


        .recent-questions,
        .ask-question,
        .teacher-section {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin: 10px;
            width: 50%;


        }

        /* Apply styles for small screens using a media query */
        @media (max-width: 768px) {
            .qa-container {
                flex-direction: column;
                /* Change to a column layout for small screens */
            }

            .recent-questions,
            .ask-question,
            .teacher-section {
                width: 100%;
                /* Take full width on small screens */
            }
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .question-link {
            display: block;
            text-decoration: none;
            color: #333;
            background-color: #e0e0e0;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            overflow: hidden;
            /* Ensure the container wraps its floated children */
        }

        .question-link:hover {
            background-color: #d0d0d0;
        }

        .question-text {
            float: left;
        }

        .question-tag {
            float: right;
            background-color: #523adb;
            color: #fff;
            padding: 2px 8px;
            border-radius: 5px;
            margin-left: 5px;
        }


        .teacher-card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .teacher-card {
            width: 30%;
            background-color: #fff;
            margin: 10px 0;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .teacher-card:hover {
            background-color: #e0e0e0;
        }

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

        .recent-questions {
            height: 400px;
            overflow-y: auto;
            position: relative;
            /* Make sure to set position relative on the container */
        }

        
    </style>
</head>

<body>
    <?php require_once "navbar.php" ?>
    <?php if ($ban_status == 1) {
      // Display a message for banned teachers
      echo '<div class="alert alert-danger" role="alert">
              You are banned by the admin. You cannot view any questions.
          </div>';
      // Optionally, you may exit the script here to prevent further execution
    
    } else { ?>
    <!-- Recently asked question start -->
    <div class="container mt-4">
        <div class="qa-container ">
            <div class="recent-questions shadow" >
                <h2>Recently Asked Questions</h2>
                <?php foreach ($recentQuestions as $index => $question) { ?>
                    <a class="question-link clearfix" href="#" data-question-tag="<?php echo $question['question_tag']; ?>"
                        data-question-text="<?php echo $question['question_text']; ?>"
                        data-question-id="<?php echo $question['question_id']; ?>">
                        <div class="question-text">
                            <?php echo ($index + 1) . '. ' . $question['question_text']; ?>
                        </div>
                        <span class="question-tag">
                            <?php echo $question['question_tag']; ?>
                        </span>
                    </a>
                <?php } ?>
            </div>
            <div class="ask-question shadow">
                <h2>Ask a Question</h2>
                <form id="askForm">
                    <input type="hidden" name="student_id" value="<?= $cid; ?>">
                    <div class="form-group">
                        <label for="subjectSelect">Select Subject</label>
                        <select class="custom-select" id="subjectSelect" name="subject">
                            <?php foreach ($all_subjects as $subject) { ?>
                                <option value="<?php echo $subject; ?>">
                                    <?php echo $subject; ?>
                                </option>
                            <?php } ?>
                            <!-- Add more subjects as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="questionText">Your Question</label>
                        <textarea class="form-control" id="questionText" name="question" rows="4"
                            placeholder="Type your question here" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Our best teacher -->
    <section >
        <div class="container py-5 h-100">
            <center>
                <h2>Our Top 6 Best Rated Teachers</h2>
            </center>
            <div class="row d-flex justify-content-center align-items-center h-100">
                <?php foreach ($teachers as $teacher) { ?>
                    <div class="col-md-4 col-xl-4 mb-4  mt-2">
                        <div class="card  shadow card-style1" style="border-radius: 15px;">
                            <div class="card-body text-center">
                                <div class="mt-3 mb-4">
                                    <img src="../teacher_panel/assets/img/uploads/profile_pic/<?php echo $teacher['profile_pic']; ?>"
                                        class="teacher-profile-pic" />
                                </div>
                                <h4 class="mb-2">
                                    <?php echo $teacher['name']; ?>
                                </h4>
                                <span class="text-truncate" style="max-width: 200px; display: inline-block;">Subjects:
                                    <?php echo $teacher['subjects']; ?>
                                </span>
                                <p class="text-muted mb-4">Qualification:
                                    <?php echo $teacher['latest_qualification']; ?>
                                </p>
                                <div class="mb-2 pb-2">
                                    <?php
                                    $fullStars = floor($teacher['overall_ratings']); // Get the full stars
                                    $halfStar = ($teacher['overall_ratings'] - $fullStars) > 0; // Check for a half star
                                
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $fullStars) {
                                            echo '<i class="fas fa-star star" data-rating="' . $i . '"></i>';
                                        } elseif ($halfStar && $i == ($fullStars + 1)) {
                                            echo '<i class="fas fa-star-half-alt star" data-rating="' . $i . '"></i>';
                                        } else {
                                            echo '<i class="far fa-star star" data-rating="' . $i . '"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- Modify the "View Full Profile" button -->
                                <a href='teacher-details-page.php?teacher_id=<?php echo $teacher['id']; ?>'
                                    class='btn btn-primary btn-rounded btn-md'>View Full Profile</a>
                                <div class="d-flex justify-content-center text-center mt-2 mb-2">
                                    <div>
                                        <p class="mb-1 h5">
                                            <?php echo $teacher['no_of_ratings']; ?>
                                        </p>
                                        <p class="text-muted mb-0">No of Ratings</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>
      <!-- BackToTop Button -->
      <a href="javascript:void(0);" id="backToTop" class="back-to-top">
        <i class="arrow"></i><i class="arrow"></i>
    </a>
    <?php require "footer.php"; ?>
     <?php } ?>

  
    <?php require "body_link.php"; ?>

</body>

</html>