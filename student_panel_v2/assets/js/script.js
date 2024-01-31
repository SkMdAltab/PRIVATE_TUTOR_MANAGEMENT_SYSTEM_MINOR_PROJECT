$(document).ready(function () {

   

    $('#askForm').submit(function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Collect form data
        var formData = $(this).serialize();
        formData += '&action=ask-question';


        // Send an AJAX request to stu-action.php
        $.ajax({
            url: 'assets/php/stu-action.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                // Handle the response from stu-action.php
                // You can update the page or display a success message here
                if (response == 'true') {
                    Swal.fire({
                        type: "success",
                        title: 'Question submited successfully',
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
            error: function (xhr, status, error) {
                // Handle errors, if any
                console.log(error);
            }
        });
    });



    $('#search_question_all').submit(function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Collect form data
        var formData = $(this).serialize();
        formData += '&action=search-question';


        // Send an AJAX request to stu-action.php
        $.ajax({
            url: 'assets/php/stu-action.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log(response);
                // Handle the response from stu-action.php
                // You can update the page or display a success message here
                window.location.href = 'all_questions.php?subjectTag=' + response;
            },
            error: function (xhr, status, error) {
                // Handle errors, if any
                console.log(error);
            }
        });
    });
    $('.question-link').click(function (e) {
        e.preventDefault();

        // Get data attributes from the clicked question
        var questionTag = $(this).data('question-tag');
        var questionText = $(this).data('question-text');
        var questionId = $(this).data('question-id');

        window.location.href = 'search_questions_answer.php?subjectTag=' + encodeURIComponent(questionTag) + '&question_text=' + encodeURIComponent(questionText) + '&question_id=' + encodeURIComponent(questionId);


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

    checkNotification()
    function checkNotification() {
        $.ajax({
            url: "assets/php/stu-action.php",
            method: 'post',
            data: { action: 'checkNotification' },
            success: function (response) {
                $("#checkNotification").html(response);
            }
        });
    }


});