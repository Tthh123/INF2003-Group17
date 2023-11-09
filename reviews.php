<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Contact Groom & Go for any queries or feedback">
        <meta name="keywords" content="Groom & Go, contact, queries, feedback">
        <meta name="author" content="Groom & Go">
        <title>Groom & Go Contact | Get in Touch</title>
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
        .star-rating {
            display: inline-block;
            font-size: 0;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            float: right;
            cursor: pointer;
            font-size: 24px;
        }

        .star-rating label:before {
            content: "\2605"; /* Unicode character for a star */
        }

        .star-rating input[type="radio"]:checked ~ label:before {
            content: "\2605"; /* Unicode character for a filled star */
            color: gold; /* Color of the filled star */
        }

    </style>


    <?php
    $page = 'submitreviews'; // change this to match the name of the page
    ?>

    <body>

        <?php
        include "nav.inc.php";
        ?>

        <section id="page-header" class="about-header">

            <h2>#Satisfaction</h2>
            <p>Feedback or Refunds? We will help you!</p>

        </section>

        <section id="form-details">
            <form id="fs-frm" name="survey-form" accept-charset="utf-8" action="process_reviews.php" method="post" enctype="multipart/form-data">

                <fieldset id="fs-frm-inputs">
                    <legend>LEAVE A REVIEW</legend>
                    <h2>We love to hear from you</h2>

                    <label for="order-number-label">Order ID</label>
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
                        echo '<input type="text" required="required" name="order_id" id="order_id" value="' . $row['order_id'] . '">';
                    } else {
                        echo '<div class="order-number">N/A</div>';
                    }


                    // Close the database connection
                    mysqli_close($conn);
                    ?>

                    <label for="full-name">Full Name</label>
                    <input type="text" required="required" name="name" id="full-name" placeholder="First and Last">

                    <label for="message">Message</label>
                    <textarea rows="3" required="required" name="message" id="message" placeholder="Tell us how you feel about the services and products!"></textarea>

                    <label for="image-upload">Upload Image</label>
                    <input type="file" name="review_image" id="review_image" accept="image/*">


                    <label for="star-rating">Star Rating</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5"><label for="star5"></label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4"></label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3"></label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2"></label>
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1"></label>
                    </div>



                </fieldset>
                <button class="normal" data-message="Review form submitted">Submit Review Form</button>
            </form>


            <div class="people">
                <div>
                    <img src="img/people/youngman.jpg" alt="Picture of senior marketing manager">
                    <p><span>Jackson Ng </span> Senior Marketing Manager <br> Phone: + 8123 4567 <br> Email: jacksonng@gmail.com</p>
                </div>
                <div>
                    <img src="img/people/sgwoman.jpg" alt="Picture of senior Production manager">
                    <p><span>Janice Lee</span> Senior Production Manager <br> Phone: + 8234 5678 <br> Email: janiclee@gmail.com</p>
                </div>
                <div>
                    <img src="img/people/oldman.jpg" alt="Picture of senior Customer manager">
                    <p><span>Robert Tan</span> Senior Customer Manager <br> Phone: + 9123 4567 <br> Email: roberttan@gmail.com</p>
                </div>
            </div>
        </section>

        <?php
        include "footer.inc.php";
        ?>

    </body>

</html>