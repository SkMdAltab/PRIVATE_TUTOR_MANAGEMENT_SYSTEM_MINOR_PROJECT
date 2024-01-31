<?php
require_once 'assets/php/session.php';
require_once 'assets/php/stu-methods.php';

$my_questions = $stu_user->MyaskedQuestions($cid);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'header_link.php' ?>
    <style>
        body {
            background-color: #f0f0f0;
        }

        .recent-questions,
        {
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        margin: 10px;
        width: 50%;


        }



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

        .question-link:hover {
            background-color: #d0d0d0;
        }

        .question-tag {
            background-color: #523adb;
            color: #fff;
            padding: 2px 8px;
            border-radius: 5px;
            margin-left: 5px;
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
</head>

<body>
    <?php require_once "navbar.php" ?>


    <div class="container mt-4">

        <div class="my_questions  " style="height: 400px; overflow-y: auto;">
            <h2>My Asked Questions</h2>
            <?php foreach ($my_questions as $index => $question) { ?>
                <a class="question-link" href="#" data-question-tag="<?php echo $question['question_tag']; ?>"
                    data-question-text="<?php echo $question['question_text']; ?>"
                    data-question-id="<?php echo $question['question_id']; ?>">
                    <?php echo ($index + 1) . '. ' . $question['question_text']; ?>
                    <span class="question-tag float-right">
                        <?php echo $question['question_tag']; ?>
                    </span>
                </a>
            <?php } ?>
        </div>


    </div>


    <!-- BackToTop Button -->
    <a href="javascript:void(0);" id="backToTop" class="back-to-top">
        <i class="arrow"></i><i class="arrow"></i>
    </a>
    <?php require "footer.php"; ?>
    <?php require "body_link.php"; ?>

</body>

</html>