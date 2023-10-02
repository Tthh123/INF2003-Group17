<?php
$page = 'index'; // change this to match the name of the page
include('nav.inc.php');
?>

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



    <style>

        .animation-container .container {
            max-width: 380px;
            margin: 50px auto;
            overflow: hidden;
        }

        .printer-top {
            z-index: 1;
            border: 6px solid #666666;
            height: 6px;
            border-bottom: 0;
            border-radius: 6px 6px 0 0;
            background: #333333;
        }

        .printer-bottom {
            z-index: 0;
            border: 6px solid #666666;
            height: 6px;
            border-top: 0;
            border-radius: 0 0 6px 6px;
            background: #333333;
        }

        .paper-container {
            position: relative;
            overflow: hidden;
            height: 467px;
        }

        .paper {
            background: #dcf0fa;
            font-family: 'Poppins', sans-serif;
            height: 447px;
            position: absolute;
            z-index: 2;
            margin: 0 12px;
            margin-top: -12px;
            animation: print 5000ms cubic-bezier(0.68, -0.55, 0.265, 0.9);
            -moz-animation: print 5000ms cubic-bezier(0.68, -0.55, 0.265, 0.9);
        }

        .main-contents {
            margin: 0 12px;
            padding: 24px;
        }

        .jagged-edge {
            background: #dcf0fa;
            position: relative;
            height: 20px;
            width: 100%;
            margin-top: -1px;
        }

        .jagged-edge:after {
            content: "";
            display: block;
            position: absolute;
            left: 0;
            right: 0;
            height: 20px;
            background: linear-gradient(45deg,
                transparent 33.333%,
                #ffffff 33.333%,
                #ffffff 66.667%,
                transparent 66.667%),
                linear-gradient(-45deg,
                transparent 33.333%,
                #ffffff 33.333%,
                #ffffff 66.667%,
                transparent 66.667%);
            background-size: 16px 40px;
            background-position: 0 -20px;
            background: #ffffff;
        }

        .success-icon {
            text-align: center;
            font-size: 48px;
            height: 72px;
            background: #359d00;
            border-radius: 50%;
            width: 72px;
            height: 72px;
            margin: 16px auto;
            color: #fff;
        }

        .success-title {
            font-size: 22px;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            color: #666;
            font-weight: bold;
            margin-bottom: 16px;
        }

        .success-description {
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            line-height: 21px;
            color: #999;
            text-align: center;
            margin-bottom: 24px;
        }

        .order-details {
            text-align: center;
            color: #333;
            font-weight: bold;

        }

        .order-number-label {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .order-number {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            line-height: 48px;
            font-size: 20px;
            padding: 8px 0;
            margin-bottom: 24px;
        }

        .complement {
            background-color: #32a852;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
            cursor: pointer;
        }

        .complement:hover {
            background-color: #fff;
            color: #32a852;
            border: 2px solid #32a852;
        }



        @keyframes print {
            0% {
                transform: translateY(-90%);
            }

            100% {
                transform: translateY(0%);
            }
        }

        @-webkit-keyframes print {
            0% {
                -webkit-transform: translateY(-90%);
            }

            100% {
                -webkit-transform: translateY(0%);
            }
        }

        @-moz-keyframes print {
            0% {
                -moz-transform: translateY(-90%);
            }

            100% {
                -moz-transform: translateY(0%);
            }
        }

        @-ms-keyframes print {
            0% {
                -ms-transform: translateY(-90%);
            }

            100% {
                -ms-transform: translateY(0%);
            }
        }
    </style>

    <body>
        <div class="animation-container">

            <div class="container">
                <div class="printer-top"></div>

                <div class="paper-container">
                    <div class="printer-bottom"></div>

                    <div class="paper">
                        <div class="main-contents">
                            <div class="success-icon">&#10004;</div>
                            <div class="success-title">
                                Payment Complete
                            </div>
                            <div class="success-description">
                                Thank you for completing the payment! Track your order in profile.
                            </div>
                            <div class="order-details">
                                <div class="order-number-label">Order ID</div>
                                <?php
                                // Create database connection
                                $config = parse_ini_file('../../private/db-config.ini');
                                $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Get the latest order_id for the session email
                                $email = $_SESSION['email'];
                                $query = "SELECT order_id FROM trackorder WHERE email='$email' ORDER BY order_id DESC LIMIT 1";
                                $result = mysqli_query($conn, $query);

                                // Display the order_id
                                if ($row = mysqli_fetch_assoc($result)) {
                                    echo '<div class="order-number">' . $row['order_id'] . '</div>';
                                } else {
                                    echo '<div class="order-number">N/A</div>';
                                }

                                // Close the database connection
                                mysqli_close($conn);
                                ?>
                                <a href="accountsetting.php">
                                    <div class="complement">Go to Profile</div>
                                </a>
                            </div>
                        </div>
                        <div class="jagged-edge"></div>
                    </div>

                </div>
            </div>
        </div>

        <?php
        include "footer.inc.php";
        ?>


    </body>
</html>