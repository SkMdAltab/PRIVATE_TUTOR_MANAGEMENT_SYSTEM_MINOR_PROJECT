<?php
require_once 'assets/php/session.php';
$teacher_id = $cid;

if($csubjects){
    $allQuestions = $tea_user->get_my_questions($teacher_id, $csubjects);
    $answeredQuestions = $tea_user->get_answered_questions($teacher_id);
    $pendingQuestions = [];
    
    foreach ($allQuestions as $question) {
        // Check if the question is answered
        if (!$tea_user->is_question_answered($question['question_id'], $teacher_id)) {
            $pendingQuestions[] = $question; // Add unanswered questions to the array
        }
    }
    $pending_question_count = count($pendingQuestions);
    $answer_question_count = count($answeredQuestions);
    
    
}else{
    $pending_question_count = 0;
    $answer_question_count = 0;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "headerLink.php"; ?>
</head>

<body>
    <div class="main">
        <?php require_once "navbar.php" ?>




        <div class="container-fluid">
            <div class="row">

                <!-- Dashboard Box 1 -->
                <div class="col-lg-6 col-md-6 col-sm-12 p-4 mt-4">
                    <div class="card rounded-4 shadow" style="width: 100%;">
                        <div class="card-header rounded-0 bg-primary">
                            <h4 class="card-title text-white mb-1">Answered Questions<i
                                    class="bi bi-hand-thumbs-up-fill ml-2 float-right"></i></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="display-4 font-weight-bold text-center mt-4" style="color: rgb(148, 54, 236);">
                                <?= $answer_question_count ?>
                            </h1>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Box 2 -->
                <div class="col-lg-6 col-md-6 col-sm-12 p-4 mt-4">
                    <div class="card rounded-4 shadow" style="width: 100%;">
                        <div class="card-header rounded-0 bg-primary">
                            <h4 class="card-title text-white mb-1">Pending Questions<i
                                    class="bi bi-arrow-clockwise ml-4 float-right"></i></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="display-4 font-weight-bold text-center mt-4" style="color: rgb(148, 54, 236);">
                                <?= $pending_question_count ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Dashboard Box 3 -->
                <div class="col-lg-6 col-md-6 col-sm-12 p-4 mt-4">
                    <div class="card rounded-4 shadow" style="width: 100%;">
                        <div class="card-header rounded-0 bg-primary">
                            <h4 class="card-title text-white mb-1">Overall Ratings<i
                                    class="bi bi-star-half ml-5 float-right"></i>
                            </h4>
                        </div>
                        <div class="card-body">
                            <h1 class="display-4 font-weight-bold text-center mt-4" style="color: rgb(148, 54, 236);"><i
                                    class="bi bi-star-fill"></i>
                                <?= $overall_ratings ?>/5
                            </h1>
                        </div>
                    </div>
                </div>


                <!-- Dashboard Box 4 -->

                <div class="col-lg-6 col-md-6 col-sm-12 p-4 mt-4">
                    <div class="card rounded-4 shadow" style="width: 100%;">
                        <div class="card-header rounded-0 bg-primary">
                            <h4 class="card-title text-white mb-1">Total No. of Ratings<i
                                    class="bi bi-view-list ml-5 float-right"></i></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="display-4 font-weight-bold text-center mt-4" style="color: rgb(148, 54, 236);">
                                <?= $no_of_ratings ?>
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