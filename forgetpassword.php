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

    </head>

    <body>
        <?php
        include "nav.inc.php";
        ?>

        <!-- Password reset section -->
        <section class="password-reset-container">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h2>Oh dear, you forgot your password?</h2>
                        <p>No worries! Just key in your details!</p>
                        <p>A security code will be sent to your email.</p>
                        <?php
                        if (isset($_SESSION['error_message'])) {
                            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                            unset($_SESSION['error_message']);
                        }
                        ?>
                        <form action="process_securitycode.php" method="post">
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input class="form-control" id="fname" required name="fname" type="text" aria-label="Enter First Name" />
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input class="form-control" id="lname" required name="lname" type="text" aria-label="Enter Last Name" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input class="form-control" id="email" required name="email" type="email" aria-label="Enter Email Address" />
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </section>

        <?php
        include "footer.inc.php";
        ?>

    </body>

</html>
