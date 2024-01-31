<?php
require_once 'assets/php/session.php';
require_once 'assets/php/stu-methods.php';


// Sample data for teacher answers
$teacherAnswers = $stu_user->GetAnswersWithTeacherDetails($_GET['question_id']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'header_link.php' ?>
    <style>
        body {

            /* background-color: #f0f0f0; */
            background-color: #f4e3ff;

            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main {
            flex: 1;
        }

        .footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 50px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* .footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 50px 0;
        } */

        .footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }

        .copyright {
            margin-top: 10px;
            font-size: 12px;
        }

        .qa-container {
            padding: 20px;
        }

        .question-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            overflow: hidden;
            /* Hide overflow content */
            position: relative;
            /* Add scroll bar if content overflows */
            max-height: 500px;
            /* Set a maximum height for scroll bar, adjust as needed */
        }

        .question-header {
            font-size: 20px;
        }

        .teacherALlAns {
            max-height: 400px;
            /* Set a maximum height for teacher answers */
            overflow: auto;
            /* Add scroll bar if content overflows */
            padding: 5px;
        }

        .teacher-answers {
            margin: 10px 0;
        }

        .teacher-info {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .teacher-profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .teacher-name {
            color: #523adb;
            font-weight: bold;
        }

        .star-rating {
            margin-left: auto;
        }

        .star {
            color: gold;
        }

        .answer {
            margin-top: 10px;
        }

        .question-tag {
            background-color: #523adb;
            color: #fff;
            padding: 2px 8px;
            border-radius: 5px;
            margin-left: 5px;
        }

        a:hover {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php require_once "navbar.php" ?>
    <div class="container mt-4  main">
        <div class="qa-container">
            <div class="question-container shadow" style="background-color: #fdf4ff;border-radius:10px;">
                <h3 class="question-header">Q:&nbsp;
                    <?= $_GET['question_text'] ?><span class="question-tag float-right">
                        <?php echo $_GET['subjectTag']; ?>
                    </span>
                </h3>
                <?php if ($teacherAnswers) { ?>
                    <div class="teacherALlAns">
                        <?php foreach ($teacherAnswers as $answer) { ?>
                            <div class="teacher-answers">
                                <div class="teacher-info">
                                    <img class="teacher-profile-pic shadow"
                                        src="../teacher_panel/assets/img/uploads/profile_pic/<?php echo $answer['teacher_profile_pic']; ?>">
                                    <!-- Make the teacher name a clickable link -->
                                    <a href="teacher-details-page.php?teacher_id=<?php echo $answer['teacher_id']; ?>"
                                        class="teacher-name">
                                        <?php echo $answer['teacher_name']; ?>
                                    </a>
                                    <div class="star-rating">
                                        <span class="star-rating-text mr-1">
                                            <?php echo $answer['no_of_ratings']; ?> Ratings
                                        </span>
                                        <?php
                                        $fullStars = floor($answer['ratings']); // Get the full stars
                                        $halfStar = ($answer['ratings'] - $fullStars) > 0; // Check for a half star
                                
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
                                    <div class="rating-input">
                                        <select class="form-control" name="rating"
                                            data-answer-id="<?php echo $answer['answer_id']; ?>"
                                            data-teacher-id="<?php echo $answer['teacher_id']; ?>"
                                            data-student-id="<?php echo $cid ?>">
                                            <option value="1">1 Star</option>
                                            <option value="2">2 Stars</option>
                                            <option value="3">3 Stars</option>
                                            <option value="4">4 Stars</option>
                                            <option value="5">5 Stars</option>
                                        </select>
                                        <button class="btn btn-sm btn-primary submit-rating mt-2">Submit Rating</button>
                                        <!-- Add the "Report Content" button -->
                                        <button class="btn btn-sm btn-danger report-content mt-2"
                                            data-answer-id="<?php echo $answer['answer_id']; ?>"
                                            data-teacher-id="<?php echo $answer['teacher_id']; ?>" data-toggle="modal"
                                            data-target="#reportModal">Report Content</button>

                                        <!-- The modal structure -->
                                        <div class="modal fade" id="reportModal" tabindex="-1" role="dialog"
                                            aria-labelledby="reportModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="reportModalLabel">Report Content</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form for reporting content -->
                                                        <form id="reportForm">
                                                            <input type="hidden" id="answerIdInput" name="answer_id">
                                                            <input type="hidden" id="teacherIdInput" name="teacher_id">
                                                            <div class="form-group">
                                                                <label for="reportReason">Report Reason:</label>
                                                                <input type="text" class="form-control" id="reportReason"
                                                                    name="report_reason" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Submit Report</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="answer">
                                    <?php echo $answer['answer_text']; ?>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <h6>Not Answered yet!</h6>
                <?php } ?>

            </div>
        </div>
    </div>

    <!-- BackToTop Button -->
    <a href="javascript:void(0);" id="backToTop" class="back-to-top">
        <i class="arrow"></i><i class="arrow"></i>
    </a>

    <?php require "footer.php"; ?>
    <?php require "body_link.php"; ?>
    <script>
        $(document).ready(function () {
            $('.submit-rating').on('click', function () {
                var answerId = $(this).siblings('select').data('answerId');
                var teacherId = $(this).siblings('select').data('teacherId');
                var studentId = $(this).siblings('select').data('studentId');
                var rating = $(this).siblings('select').val();
                $.ajax({
                    type: 'POST',
                    url: 'assets/php/stu-action.php', // Change this to the actual PHP script handling the update
                    data: { action: 'rate_teacher_answer', answerId: answerId, teacherId: teacherId, studentId: studentId, rating: rating },
                    success: function (response) {
                        // Update the UI or handle success as needed
                        if (response == 'true') {
                            Swal.fire({
                                type: "success",
                                title: 'Rating Submited',
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
                                type: "warning",
                                title: ' You have already rated the answer!',
                                customClass: {
                                    confirmButton: 'custom-ok-button-class' // Add your custom class name here
                                }
                            }).then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });


            $('.report-content').on('click', function () {
                var answerId = $(this).data('answer-id');
                var teacherId = $(this).data('teacher-id');
                $('#answerIdInput').val(answerId);
                $('#teacherIdInput').val(teacherId);
            });

            // Submit report using AJAX when the form is submitted
            $('#reportForm').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'assets/php/stu-action.php', // Replace with the actual PHP script handling the report
                    data: $(this).serialize() + '&action=report_form_submit',
                    success: function (response) {
                        // Handle success response
                        console.log(response);
                        // Close the modal
                        $('#reportModal').modal('hide');
                        if (response == 'true') {
                            Swal.fire({
                                type: "success",
                                title: 'Report Submited',
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
                                type: "warning",
                                title: ' You have already Report the answer!',
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
                });
            });
        });
    </script>
</body>


</html>