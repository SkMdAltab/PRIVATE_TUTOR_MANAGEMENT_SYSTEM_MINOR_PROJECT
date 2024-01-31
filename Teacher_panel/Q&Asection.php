<!DOCTYPE html>
<html lang="en">
<?php
require_once 'assets/php/session.php';
$ban_status_teacher = $ban_status;
$teacher_id = $cid;



if ($ban_status_teacher == 0) {
  $allQuestions="";
  $answeredQuestions="";
  $pendingQuestions = [];
  if($csubjects){
    $allQuestions = $tea_user->get_my_questions($teacher_id, $csubjects);
    $answeredQuestions = $tea_user->get_answered_questions($teacher_id);
    
  foreach ($allQuestions as $question) {
    // Check if the question is answered
    if (!$tea_user->is_question_answered($question['question_id'], $teacher_id)) {
      $pendingQuestions[] = $question; // Add unanswered questions to the array
    }
  }
  }
  

  // Optionally, you may exit the script here to prevent further execution

}



?>

<head>
  <?php require_once "headerLink.php"; ?>
  <style>
    .user-questions-scrollableA {
      max-height: 470px;
      /* Set a maximum height for scrollability */
      overflow-y: auto;
      /* Add a vertical scrollbar when content exceeds the maximum height */
    }

    .user-questions-scrollable {
      max-height: 350px;
      /* Set a maximum height for scrollability */
      overflow-y: auto;
      /* Add a vertical scrollbar when content exceeds the maximum height */
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

    .question-edit-link,
    .question-edit-link:hover {
      display: block;
      text-decoration: none;
      color: #333;
      background-color: #e0e0e0;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
    }

    .question-edit-link:hover {
      background-color: #d0d0d0;
    }
  </style>

</head>

<body>
  <div class="main">
    <?php require_once "navbar.php" ?>
    <?php if ($ban_status_teacher == 1) {
      // Display a message for banned teachers
      echo '<div class="alert alert-danger" role="alert">
              You are banned by the admin. You cannot view any questions.
          </div>';
      // Optionally, you may exit the script here to prevent further execution
    
    } else if ($approve_certificate != 1) { ?>

        <div class="alert alert-danger" role="alert">
          Your certificate not yet verified!!, Wait for admin approval!!
        </div>


    <?php } else { ?>
        <div class="container">
          <div class="row justify-content-center mt-4">
            <div class="col-md-6 mb-2 ">
              <div class="card border-primary shadow">
                <div class="card-header text-center text-white bg-primary">
                  <h5><i class="float-left bi bi-hand-thumbs-up-fill ml-2"></i>Answered Questions</h5>
                </div>
                <div class="card-body user-questions-scrollableA">
                  <!-- Display answered questions here -->
                <?php 
                if($answeredQuestions){
                  foreach ($answeredQuestions as $question) { ?>
                    <a href="#" class="question-edit-link" data-toggle="modal" data-target="#EditQuestionModel"
                      data-question-id="<?= $question['question_id'] ?>" data-answer-id="<?= $question['answer_id'] ?>">
                      <div class="question">
                        <span class="user-name">
                        <?= $question['student_name'] . ": " ?>
                        </span>
                        <span class="question-text">
                          <strong>
                          <?= $question['question_text'] ?>
                          </strong>
                        </span>
                        <span class="time-posted float-right">
                        <?= $tea_user->timeInAgo($question['answer_created_at']) ?>
                        </span>
                      </div>
                    </a>
                <?php } ?>
               <?php }?>
                
                </div>
              </div>
            </div>
            <!-- Pending questions -->
            <div class="col-md-6">
              <div class="card border-primary shadow">
                <div class="card-header bg-primary text-white text-center">
                  <h5><i class="float-left bi bi-arrow-clockwise ml-4"></i>Pending Questions</h5>
                </div>
                <div class="card-body">
                  <div class="filter">
                    <label for="subjectSelect">Filter by Subject:</label>
                    <select class="custom-select mb-2" id="subjectSelect">
                    <?php foreach ($csubjects as $subject) { ?>
                        <option value="<?php echo $subject; ?>">
                        <?php echo $subject; ?>
                        </option>
                    <?php } ?>
                      <!-- Add more subjects as needed -->
                    </select>
                  </div>
                  <div class="user-questions-scrollable" id="pendingQuestionsContainer">
                    <!-- Display pending questions here -->
                  <?php foreach ($pendingQuestions as $question) { ?>
                      <a href="#" class="question-link" data-toggle="modal" data-target="#pendingQuestionModel"
                        data-question-id="<?= $question['question_id'] ?>"
                        data-question-text="<?= $question['question_text'] ?>"
                        data-student-id="<?= $question['student_id'] ?>">
                        <div class="question">
                          <span class="user-name">
                          <?= $question['student_name'] . ": " ?>
                          </span>
                          <span class="question-text">
                            <strong>
                            <?= $question['question_text'] ?>
                            </strong>
                          </span>
                          <span class="time-posted float-right">
                          <?= $tea_user->timeInAgo($question['created_at']) ?>
                          </span>
                        </div>
                      </a>
                  <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    <?php } ?>

    <!-- Pending questions modal start -->
    <div class="modal fade" id="pendingQuestionModel" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title">Answer the Question</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
            <!-- Hidden input field to store the question ID -->
            <input type="hidden" id="question_id" />
            <input type="hidden" id="question_text" />
            <input type="hidden" id="student_id" />

            <!-- Display the pending question and provide an input for the answer -->
            <div id="modal-pending-question"></div>
            <div class="form-group">
              <label for="answer" class="col-form-label">Your Answer:</label>
              <textarea class="form-control" rows="8" id="answer" name="answer" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="submitAnswerBtn">Submit Answer</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Pending questions modal end -->

    <!-- start edit(when we click edit button in action menu) note modal -->
    <div class="modal fade" id="EditQuestionModel" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title">Edit Question</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
            <!-- Hidden input field to store the question ID -->
            <input type="hidden" id="edit_question_id" />
            <!-- Display the question to be edited and provide input fields for editing -->
            <div id="modal-edit-question"></div>

            <div class="form-group">
              <label for="edit_note" class="col-form-label">Answer:</label>
              <textarea class="form-control" rows="6" id="edit_note" name="edit_note" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

          </div>
        </div>
      </div>
    </div>
    <!-- end edit  note modal -->

  </div>

  <?php require_once "body_link.php" ?>

  <script>
    $(document).ready(function () {


      $('#subjectSelect').on('change', function () {
        const selectedSubject = $(this).val();

        // Filter questions based on the selected subject
        const filteredQuestions = <?= json_encode($pendingQuestions); ?>.filter(function (question) {
          return question.question_tag === selectedSubject;
        });

        // Update the pending questions container with the new content
        updatePendingQuestions(filteredQuestions);
      });
      // Handle clicking on a pending question link
      // Handle clicking on a pending question link
      $(document).on('click', '.question-link', function () {
        const questionID = $(this).data('question-id');
        const questionText = $(this).find('.question-text').text();
        const studentID = $(this).data('student-id'); // Add this line to get student ID

        // Populate the modal with the pending question
        $('#modal-pending-question').html('<strong>' + questionText + '</strong>');

        // Store the question ID, student ID, and question text in hidden input fields
        $('#question_id').val(questionID);
        $('#student_id').val(studentID); // Set the student ID
        $('#question_text').val(questionText); // Set the question text


      });



      $(document).on('click', '.question-edit-link', function () {
        const questionID = $(this).data('question-id');
        const answerID = $(this).data('answer-id');
        const questionText = $(this).find('.question-text').text();

        const boldedQuestionText = '<strong>' + questionText + '</strong>';

        // Populate the modal with the answered question
        $('#modal-edit-question').html(boldedQuestionText);
        // Store the question ID and answer ID in hidden input fields (for reference when updating the answer)
        $('#edit_question_id').val(questionID);
        $('#answer_id').val(answerID);

        // Fetch and display the previous answer in the answer input field
        $.ajax({
          type: 'POST',
          url: 'assets/php/tea-action.php', // Modify the URL to your action.php
          data: {
            action: 'fetch_answer',
            answer_id: answerID,
          },
          success: function (response) {
            // Populate the answer input field with the fetched answer
            $('#edit_note').val(response);
          },
        });
      });




      // Handle submitting the answer
      $('#submitAnswerBtn').on('click', function () {
        // Get the answer text
        const answerText = $('#answer').val();

        // Get the question ID
        const questionID = $('#question_id').val();
        const student_id = $('#student_id').val();
        const question_text = $('#question_text').val();

        // You can use AJAX to send the answer and question ID to the server (action.php)
        $.ajax({
          type: 'POST',
          url: 'assets/php/tea-action.php', // Modify the URL to your action.php
          data: {
            action: 'submit_answer',
            question_id: questionID,
            answer: answerText,
            student_id: student_id,
            question_text: question_text
          },
          success: function (response) {
            if (response === 'success') {
              // Handle success (e.g., remove the question from pending and add it to answered)
              // You can implement this based on your data structure
              // Close the modal
              $('#pendingQuestionModel').modal('hide');
              Swal.fire({
                type: "success",
                title: 'Answer submited successfully',
              }).then((result) => {
                if (result.value) {
                  location.reload();
                }
              });
            } else {
              // Handle error
              console.log('Error: ' + response);
            }
          },
        });
      });


      // Function to update pending questions container
      function updatePendingQuestions(questions) {
        const container = $('#pendingQuestionsContainer');
        container.empty();

        questions.forEach(function (question) {
          const relativeTime = getRelativeTime(question.created_at);
          container.append('<a href="#" class="question-link" data-toggle="modal" data-target="#pendingQuestionModel" data-question-id="' + question.question_id + '">'
            + '<div class="question">'
            + '<span class="user-name">' + question.student_name + ': ' + '</span>' + '<strong>'
            + '<span class="question-text">' + question.question_text + '</strong>' + '</span>'
            + '<span class="time-posted float-right">' + relativeTime + '</span>'
            + '</div>'
            + '</a>');
        });
      }


      // Function to get relative time
      function getRelativeTime(createdAt) {
        const currentTime = new Date();
        const postedTime = new Date(createdAt);
        const timeDifference = Math.floor((currentTime - postedTime) / 1000); // in seconds

        if (timeDifference < 60) {
          return timeDifference + ' seconds ago';
        } else if (timeDifference < 3600) {
          const minutes = Math.floor(timeDifference / 60);
          return minutes + (minutes === 1 ? ' minute ago' : ' minutes ago');
        } else if (timeDifference < 86400) {
          const hours = Math.floor(timeDifference / 3600);
          return hours + (hours === 1 ? ' hour ago' : ' hours ago');
        } else {
          const days = Math.floor(timeDifference / 86400);
          return days + (days === 1 ? ' day ago' : ' days ago');
        }
      }
    });
  </script>
</body>


</html>