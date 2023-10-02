<?php
$page = 'about'; // change this to match the name of the page
include('nav.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Groom & Go - About Us.">
        <title>Groom & Go - About Us</title>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 

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


        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <section id="page-header" class="about-header">
            <h2>About Groom & Go</h2>
            <p>Groom & Go is a shop that sells high-quality hair styling products from top brands. <br>
                We believe that every person deserves to have great hair, and that starts with using the right products.</p>
        </section>
        <br>
        <section id="about-head" class="section-p1">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img src="img/about/hairsalon.jpg" alt="Groom and Go" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <h2>How We Started</h2>
                        <p>Groom and Go is a hair styling product shop based in Singapore. Our mission is to provide our customers with the best hair styling products that cater to any hair styling needs.</p>
                        <p>Established at the start of 2023, we have been constantly researching and expanding our product range to bring our customers the best hair styling products.</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="why-choose-us" class="section-p1">
            <div class="container">
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <h2>Why Choose Us</h2>
                        <h3>Wide Range of Products</h3>
                        <p>Our products cater to any hair styling needs, from hair wax or coloured wax that gives your hair a raw natural look to products that can protect your hair from getting damaged when using straighteners.</p>
                        <h3>Expert Advice</h3>
                        <p>Most of our product pages come with a short description to better guide our customers on the usage of the product purchased. Our team of experts are also available to answer any questions you may have about our products.</p>
                    </div>
                    <div class="col-md-6">
                        <img src="img/about/hairsalon1.jpg" alt="Hair Salon" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>
        <section id="our-values" class="section-p1">
            <div class="container">
                <h2>Our Values</h2><br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="value-box">
                            <i class="fas fa-certificate" ></i><br><br>
                            <h4>Quality</h4>
                            <p>We are committed to providing our customers with high-quality hair styling products that are effective and safe to use.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="value-box">
                            <i class="fas fa-hand-holding-usd"></i><br><br>
                            <h4>Affordability</h4>
                            <p>We believe that everyone should have access to great hair styling products without breaking the bank.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="value-box">
                            <i class="fas fa-handshake"></i><br><br>
                            <h4>Customer Satisfaction</h4>
                            <p>We value our customers and aim to provide excellent customer service and satisfaction.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        include "footer.inc.php";
        ?>

    </body>
</html>