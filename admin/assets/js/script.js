$(document).ready(function () {
  $("#navBtn").click(function () {
    $(".main").toggleClass('animate');
  });

  var currentURL = window.location.href;

  // Check the URL to determine the active link
  if (currentURL.includes("admin-dashboard.php")) {
    $("#dashboard-link").addClass("link-active");
  } else if (currentURL.includes("user-management.php")) {
    $("#usermanagement-link").addClass("link-active");
  } else if (currentURL.includes("change_pass.php")) {
    $("#changePassword-link").addClass("link-active");
  } else if (currentURL.includes("report_content.php")) {
    $("#report-content-link").addClass("link-active");
  } else if (currentURL.includes("all_query_view.php")) {
    $("#all_query_view").addClass("link-active");
  }


});
