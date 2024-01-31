$(document).ready(function () {
  $("#navBtn").click(function () {
    $(".main").toggleClass('animate');
    // $('#teacher_panel_text').toggle();//hide and show
  });

  var currentURL = window.location.href;

  // Check the URL to determine the active link
  if (currentURL.includes("dashboard.php")) {
    $("#dashboard-link").addClass("link-active");
  } else if (currentURL.includes("Q&Asection.php")) {
    $("#Q_Asection-link").addClass("link-active");
  } else if (currentURL.includes("profile.php")) {
    $("#profile-link").addClass("link-active");
  } else if (currentURL.includes("contact_admin.php")) {
    $("#contact-admin-link").addClass("link-active");
  } else if (currentURL.includes("change_pass.php")) {
    $("#changePassword-link").addClass("link-active");
  } else if (currentURL.includes("notification.php")) {
    $("#notification-link").addClass("link-active");
  }

  $("#changePassForm").submit(function (event) {
    event.preventDefault(); // Prevent the default form submission

    if ($('#newpass').val() !== $('#cnewpass').val()) {
      $("#userPassError").text("*confirm Password did not matched !");

    } else {
      $("#userPassError").text("");
      $.ajax({
        url: "../Teacher_panel/assets/php/tea-action.php",
        method: 'post',
        data: $('#changePassForm').serialize() + '&action=changePass',
        success: function (response) {

          console.log(response, 1);
          if (response == 'true') {
            $('#changePassForm')[0].reset();
            Swal.fire({
              type: "success",
              title: 'Password updated successfully',
              customClass: {
                confirmButton: 'custom-ok-button-class' // Add your custom class name here
              }
            })

          } else {
            $("#userPassError").text("* Current password did not matched !");

          }
        }
      })
    }
  });
  $("#contact-admin-form").submit(function (event) {
    event.preventDefault(); // Prevent the default form submission



    $.ajax({
      url: "../Teacher_panel/assets/php/tea-action.php",
      method: 'post',
      data: $('#contact-admin-form').serialize() + '&action=contact_with_admin',
      success: function (response) {


        if (response == 'true') {
          $('#contact-admin-form')[0].reset();
          Swal.fire({
            type: "success",
            title: 'Form submission successfully',
            customClass: {
              confirmButton: 'custom-ok-button-class' // Add your custom class name here
            }
          })

        }
      }
    })

  });



});
