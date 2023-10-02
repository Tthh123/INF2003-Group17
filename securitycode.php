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

        <!-- Security code section -->
        <section class="security-code-container">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h2>Security code</h2>

                        <?php
                        if (isset($_SESSION['error_message'])) {
                            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                            unset($_SESSION['error_message']);
                        }
                        ?>

                        <form id="security-code-form" action="https://formsubmit.co/<?php echo $_SESSION['emailsecurity_code']; ?>" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="security_code" value="<?php echo $_SESSION['security_code']; ?>">
                                <label for="security-code" class="sr-only">Security Code</label>
                                <label>Click the button to get the security code</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Security Code</button>
                            <input type="hidden" name="_next" value="https://35.212.180.138/ProjectPhp/securitycode.php">
                        </form>

                        <BR>

                        <form action="verify_security_code.php" method="post">
                            <div class="form-group">
                                <label for="security-code" class="sr-only">Enter Security Code</label>
                                <label>Should be in your email anytime soon.</label>
                                <input class="form-control" id="security-code" required name="security_code" type="text" placeholder="Security Code" />
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Security Code</button>
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