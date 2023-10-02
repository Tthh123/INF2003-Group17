<?php
$page = 'faillogin'; // change this to match the name of the page
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Groom & Go</title>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 
        <link rel="stylesheet" href="style.css">

        <!-- ====== Custom Js ====== -->
        <script defer src="script.js"></script>

        <!-- ====== Boxicons ====== -->
        <link
            href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
            rel="stylesheet"
            />
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

        <!-- Add custom styles for the error message -->
        <style>
            .error-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 50vh;
            }

            .alert {
                max-width: 600px;
                text-align: center;
            }

            .error-message {
                margin-bottom: 20px;
            }

        </style>


    </head>

    <body>
        <?php
        include "nav.inc.php";
        ?>


        <!-- Error message section -->
        <section class="error-container">
            <?php
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger" role="alert">';
                echo '<h4>Oops... Something went wrong? Try again.</h4>';
                echo '<p class="error-message"><strong>' . $_SESSION['error_message'] . '</strong></p>';
                echo '<a href="contact.php" class="btn btn-primary">Contact Us For Help</a>';
                echo '</div>';
                unset($_SESSION['error_message']); // Clear error message
            }
            ?>
        </section>



        <?php
        include "footer.inc.php";
        ?>

    </body>

</html>