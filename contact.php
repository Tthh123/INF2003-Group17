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

    <?php
    $page = 'contact'; // change this to match the name of the page
    ?>

    <body>

        <?php
        include "nav.inc.php";
        ?>

        <section id="page-header" class="about-header">

            <h2>#let's_talk</h2>
            <p>Questions, Feedback, Refunds? We love to hear from you!</p>

        </section>

        <section id="contact-details" class="section-p1">
            <div class="details">
                <span>GET IN TOUCH</span>
                <h2>Visit one of our agency locations or contact us today</h2>
                <h3>Head Office</h3>
                <div>
                    <ul>
                        <li>
                        <i class="fal fa-map"></i>
                        <p>311 New Upper Changi Rd, Singapore 467360</p>
                        </li>
                        <li>
                            <i class="far fa-envelope"></i>
                            <p>groomandgo@gmail.com </p>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <p>+65 65248790</p>
                        </li>
                        <li>
                            <i class="far fa-clock"></i>
                            <p>Monday to Saturday: 9.00am to 6.00pm </p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="google-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15955.007837819408!2d103.929343!3d1.3247162!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da22cac116cd47%3A0x59401d9a012e23f3!2sBedok%20Mall!5e0!3m2!1sen!2ssg!4v1679899695522!5m2!1sen!2ssg" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
        </section>

        <section id="form-details">
            <form id="fs-frm" name="survey-form" accept-charset="utf-8" action="https://formspree.io/f/myyadoge" method="post">
                <fieldset id="fs-frm-inputs">
                    <legend>LEAVE A MESSAGE</legend>
                    <h2>We love to hear from you</h2>
                    <label for="full-name">Full Name</label>
                    <input type="text" required="required" name="name" id="full-name" placeholder="First and Last">
                    <label for="email-address">Email Address</label>
                    <input type="email" required="required" name="email" id="email-address" placeholder="email@domain.tld">
                    <label for="message">Message</label>
                    <textarea rows="3" required="required" name="message" id="message" placeholder="Include your orderID for refund. We will get back to you shortly!"></textarea>
                    <input type="hidden" name="_subject" id="email-subject" value="Contact Form">
                </fieldset>
                <button class="normal" data-message="Contact form submitted" onclick="showSuccessMessage(event)">Submit Contact Form</button>
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