<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Groom & Go</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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


        <?php
        //this is just to make all the error msg empty
        $email = $errorMsg = "";
        $pwd = $errorMsg = "";
        $lname = $errorMsg = "";
        $fname = $errorMsg = "";
        $success = true;

        if (empty($_POST["lname"])) {
            $errorMsg .= "Please enter your name.<br>";
            $success = false;
        } else {
            $lname = sanitize_input($_POST["lname"]);

            if ($lname !== ($_POST["lname"])) {
                $errorMsg .= "Please enter your real name.<br>";
                $success = false;
            }
        }

        if (empty($_POST["fname"])) {
            
        } else {
            $fname = sanitize_input($_POST["fname"]);

            if ($fname !== ($_POST["fname"])) {
                $errorMsg .= "Please enter your real name.<br>";
                $success = false;
            }
        }



        if (empty($_POST["email"])) {
            $errorMsg .= "Email is required.<br>";
            $success = false;
        } else {
            $email = sanitize_input($_POST["email"]);

            // Additional check to make sure email address is well formed.
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMsg .= "Invalid email format.";
                $success = false;
            }
        }

        if (empty($_POST["password"])) {
            $errorMsg .= "Password is required.<br>";
            $success = false;
        } else if ($_POST["password"] !== $_POST["confirm_password"]) {
            $errorMsg .= "Passwords do not match!<br>";
            $success = false;
        }

        if ($success) {
            $pwd = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $pwd = password_hash($_POST["confirm_password"], PASSWORD_DEFAULT);
            saveMemberToDB();
        }

        if ($success) {
            echo "<div class='container-fluid'>";
            echo "<div class='row justify-content-center mt-5'>";
            echo "<div class='col-lg-6'>";
            echo "<div class='card'>";
            echo "<div class='card-body text-center'>";
            echo "<h2 class='card-title mb-4'><b>Your registration is successful!</b></h2>";
            echo "<p class='card-text'>Thank you for signing up, " . $_POST["fname"] . " " . $lname . "!</p>";

            echo "<div class='icon user-icon d-flex justify-content-center'>";
            echo "<button class='btn btn-primary user-link' href='#'>Login Now!</button>";
            echo "</div>";

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div class='container-fluid'>";
            echo "<div class='row justify-content-center mt-5'>";
            echo "<div class='col-lg-6'>";
            echo "<div class='card'>";
            echo "<div class='card-body text-center'>";
            echo "<h2 class='card-title mb-4'>Oops!<br>The following errors were detected:</h2>";
            echo "<p class='card-text'>" . $errorMsg . "</p>";

            echo "<div class='icon user-icon d-flex justify-content-center'>";
            echo "<button class='btn btn-primary user-link' href='#'>Try Again?</button>";
            echo "</div>";

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        // Helper function that checks input for malicious or unwanted content.
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        /*
         * Helper function to write the member data to the DB
         */

        function saveMemberToDB() {
            global $fname, $lname, $email, $pwd, $errorMsg, $success;

            // Create database connection.
            $config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

            // Check connection
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } else {
                // Check if email already exists
                $stmt = $conn->prepare("SELECT * FROM world_of_pets_members WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    // Email already exists, set error message and return
                    $errorMsg = "Email already in use.";
                    $success = false;
                } else {
                    // Email doesn't exist, insert new record
                    $stmt = $conn->prepare("INSERT INTO world_of_pets_members (fname, lname, email, password) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $fname, $lname, $email, $pwd);
                    if (!$stmt->execute()) {
                        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                        $success = false;
                    }
                    $stmt->close();
                }
            }
            $conn->close();
        }
        ?>

        <?php
        include "newsletter.inc.php";
        ?>

        <?php
        include "footer.inc.php";
        ?>

        <?php
        include "register.php";
        ?>

    </body>