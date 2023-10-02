<?php
$page = 'logout'; // change this to match the name of the page
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

        <style>
            .logout-container {
                background-color: #fff;
                width: 500px;
                padding: 2rem;
                border-radius: 5px;
                box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
                text-align: center;
                margin: 0 auto;
                margin-top: 5rem;
            }

            .logout-container h1 {
                font-size: 2rem;
                margin-bottom: 1rem;
                color: #333;
            }

            .logout-container p {
                font-size: 1rem;
                margin-bottom: 1.5rem;
                color: #666;
            }

            .logout-container a {
                display: inline-block;
                background-color: #333;
                color: #fff;
                padding: 10px 20px;
                border-radius: 5px;
                font-size: 1rem;
                margin-top: 1rem;
                transition: background-color 0.3s ease;
            }

            .logout-container a:hover {
                background-color: #555;
            }
        </style>

    </head>

    <body>
        <?php
        include "nav.inc.php";
        ?>


        <div class="logout-container">
            <h1>You have been successfully logged out.</h1>
            <p>Thank you for using our website.</p>
            <a href="index.php">Go to Home Page</a>
        </div>
        
        <?php
        include "footer.inc.php";
        ?>
        
    </body>

</html>