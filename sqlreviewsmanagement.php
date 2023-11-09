<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Contact Groom & Go for any queries or feedback">
        <meta name="keywords" content="Groom & Go, contact, queries, feedback">
        <meta name="author" content="Groom & Go">
        <title>Groom & Go Managing Reviews SQL</title>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 
        <link rel="stylesheet" href="style.css">


        <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script defer src="sweetalert2.all.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- ====== Custom Js ====== -->
        <script defer src="script.js"></script>

        <!-- ====== Boxicons ====== -->
        <link
            href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
            rel="stylesheet"
            >

        <!--jQuery--> 
        <script defer 
                src="https://code.jquery.com/jquery-3.4.1.min.js" 
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" 
                crossorigin="anonymous">
        </script> 

        <!--Bootstrap JS--> 
        <script defer 
                src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" 
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" 
                crossorigin="anonymous">
        </script> 


    </head>

    <style>

    </style>


    <?php
    $page = 'reviews'; // change this to match the name of the page
    ?>



    <body>

        <?php
        include "nav.inc.php";
        ?>



        <section id="page-header">
            <h2>#Manage Reviews using SQL</h2>
        </section>

        <section id="reviews-management" class="container my-4">
            <div class="batch-insert-section">
                <h3>Batch Insert Records</h3>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <button id="insert-1k" class="btn btn-primary btn-block">Insert 1K Records</button>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button id="insert-10k" class="btn btn-primary btn-block">Insert 10K Records</button>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button id="insert-50k" class="btn btn-primary btn-block">Insert 50K Records</button>
                    </div>
                </div>
                <div id="insert-results"></div>
            </div>

            <!-- Filter by rating section -->
            <?php include "process_sqlreviewssinglesearch.php"; ?>

        </section>

        <!-- Filter by rating section -->
        <?php include "process_sqlbatchsearch.php"; ?>

        <script>
            // Add event listeners to the buttons
            document.getElementById('insert-1k').addEventListener('click', function () {
                batchInsert(1000);
            });

            document.getElementById('insert-10k').addEventListener('click', function () {
                batchInsert(10000);
            });

            document.getElementById('insert-50k').addEventListener('click', function () {
                batchInsert(50000);
            });

            // Function to perform batch inserts
            function batchInsert(recordCount) {
                const data = {recordCount: recordCount};
                $.ajax({
                    url: 'process_sqlbatchinsert.php',
                    type: 'POST',
                    data: data,
                    beforeSend: function () {
                        $('#insert-results').html('<div>Loading...</div>');
                    },
                    success: function (response) {
                        $('#insert-results').html('<div>' + response + '</div>');
                    },
                    error: function () {
                        $('#insert-results').html('<div>Error in batch insert.</div>');
                    }
                });
            }
        </script>


    </body>

</html>