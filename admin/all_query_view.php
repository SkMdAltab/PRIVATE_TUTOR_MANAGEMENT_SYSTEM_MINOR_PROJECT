<?php
require_once 'assets/php/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "header_link.php"; ?>
</head>

<body>
    <div class="main">
        <?php require_once "navbar.php" ?>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <center>
                        <h4 id="heading_user_management" class="mt-2">View Queries</h4>
                    </center>

                    <div id="teacher-query" style="display: none;">
                        <div class="table-responsive" id="query_T">
                            <!--table start -->

                            <!-- here data table is shown -->

                            <!-- table end -->
                        </div>

                    </div>
                </div>
            </div>
        </div>




    </div>


    <?php require_once "body_link.php" ?>
    <script>
        $(document).ready(function () {
            function display_query() {
                $.ajax({
                    url: "assets/php/admin-action.php",
                    method: 'post',
                    data: { action: 'display_query' },
                    success: function (response) {
                        console.log(response);
                        $('#teacher-query').show();
                        $("#query_T").html(response);
                        // data table for pagination
                        initializeTeacher_query_table();

                    }
                });
            }
            display_query();
            function initializeTeacher_query_table() {
                $("#teacher-query-table").DataTable({
                    order: [0, 'desc'],
                    "iDisplayLength": 5,
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            }


            $(document).on("click", ".query-resolve-button", function () {
           
                var qid = $(this).data("id");
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'POST',
                    data: {
                        action: 'query_resolve',
                        qid: qid
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            type: "success",
                            title: 'Resolve',
                            customClass: {
                                confirmButton: 'custom-ok-button-class' // Add your custom class name here
                            }
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }
                });
            });

            $(document).on("click", ".unban-teacher-button", function () {
                var userId = $(this).data("id");
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'POST',
                    data: {
                        action: 'unban_teacher',
                        userId: userId
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            type: "success",
                            title: 'Unban Successful',
                            customClass: {
                                confirmButton: 'custom-ok-button-class' // Add your custom class name here
                            }
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }
                });
            });


        });
    </script>
</body>

</html>