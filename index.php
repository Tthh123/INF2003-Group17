<?php
$page = 'index'; // change this to match the name of the page
include('nav.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>


        <title>Groom & Go - Your One-Stop Shop for Hair Products</title>
        <meta name="description" content="Shop the latest hair products from Groom & Go. We offer a wide selection of hair wax, brushes, shampoos, and more.">
        <meta name="keywords" content="hair products, hair wax, hair brush, shampoo, Groom & Go">
        <meta name="robots" content="index, follow">
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

        <style>
            .popup {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fff;
                border: 1px solid #000;
                padding: 20px;
                z-index: 9999;
            }
        </style>

    </head>

    <body>
        <div class="notification-box flex items-center justify-center">
            <!-- Notification container -->
        </div>

        <!-- Start of slider with carousel effect by bootstrap -->
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <section id="hero" >

                        <h4>Unleash Your Hair's Potential</h4>
                        <h2>Where Style Meets Substance</h2>

                        <h1><span class="magic">
                                <span class="magic-star">
                                    <svg viewBox="0 0 512 512">
                                    <path d="M512 255.1c0 11.34-7.406 20.86-18.44 23.64l-171.3 42.78l-42.78 171.1C276.7 504.6 267.2 512 255.9 512s-20.84-7.406-23.62-18.44l-42.66-171.2L18.47 279.6C7.406 276.8 0 267.3 0 255.1c0-11.34 7.406-20.83 18.44-23.61l171.2-42.78l42.78-171.1C235.2 7.406 244.7 0 256 0s20.84 7.406 23.62 18.44l42.78 171.2l171.2 42.78C504.6 235.2 512 244.6 512 255.1z" />
                                    </svg>
                                </span>    <span class="magic-star">
                                    <svg viewBox="0 0 512 512">
                                    <path d="M512 255.1c0 11.34-7.406 20.86-18.44 23.64l-171.3 42.78l-42.78 171.1C276.7 504.6 267.2 512 255.9 512s-20.84-7.406-23.62-18.44l-42.66-171.2L18.47 279.6C7.406 276.8 0 267.3 0 255.1c0-11.34 7.406-20.83 18.44-23.61l171.2-42.78l42.78-171.1C235.2 7.406 244.7 0 256 0s20.84 7.406 23.62 18.44l42.78 171.2l171.2 42.78C504.6 235.2 512 244.6 512 255.1z" />
                                    </svg>
                                </span>    <span class="magic-star">
                                    <svg viewBox="0 0 512 512">
                                    <path d="M512 255.1c0 11.34-7.406 20.86-18.44 23.64l-171.3 42.78l-42.78 171.1C276.7 504.6 267.2 512 255.9 512s-20.84-7.406-23.62-18.44l-42.66-171.2L18.47 279.6C7.406 276.8 0 267.3 0 255.1c0-11.34 7.406-20.83 18.44-23.61l171.2-42.78l42.78-171.1C235.2 7.406 244.7 0 256 0s20.84 7.406 23.62 18.44l42.78 171.2l171.2 42.78C504.6 235.2 512 244.6 512 255.1z" />
                                    </svg>
                                </span>
                                <span class="magic-text">Your Hair, Your Rules</span>
                            </span></h1>

                    </section>
                </div>
                <div class="carousel-item">
                    <section id="hair" >
                        <h4>Not Just a New Look</h4>
                        <h2>We Help You Feel</h2>

                        <h1><span class="magic">
                                <span class="magic-star">
                                    <svg viewBox="0 0 512 512">
                                    <path d="M512 255.1c0 11.34-7.406 20.86-18.44 23.64l-171.3 42.78l-42.78 171.1C276.7 504.6 267.2 512 255.9 512s-20.84-7.406-23.62-18.44l-42.66-171.2L18.47 279.6C7.406 276.8 0 267.3 0 255.1c0-11.34 7.406-20.83 18.44-23.61l171.2-42.78l42.78-171.1C235.2 7.406 244.7 0 256 0s20.84 7.406 23.62 18.44l42.78 171.2l171.2 42.78C504.6 235.2 512 244.6 512 255.1z" />
                                    </svg>
                                </span>    <span class="magic-star">
                                    <svg viewBox="0 0 512 512">
                                    <path d="M512 255.1c0 11.34-7.406 20.86-18.44 23.64l-171.3 42.78l-42.78 171.1C276.7 504.6 267.2 512 255.9 512s-20.84-7.406-23.62-18.44l-42.66-171.2L18.47 279.6C7.406 276.8 0 267.3 0 255.1c0-11.34 7.406-20.83 18.44-23.61l171.2-42.78l42.78-171.1C235.2 7.406 244.7 0 256 0s20.84 7.406 23.62 18.44l42.78 171.2l171.2 42.78C504.6 235.2 512 244.6 512 255.1z" />
                                    </svg>
                                </span>    <span class="magic-star">
                                    <svg viewBox="0 0 512 512">
                                    <path d="M512 255.1c0 11.34-7.406 20.86-18.44 23.64l-171.3 42.78l-42.78 171.1C276.7 504.6 267.2 512 255.9 512s-20.84-7.406-23.62-18.44l-42.66-171.2L18.47 279.6C7.406 276.8 0 267.3 0 255.1c0-11.34 7.406-20.83 18.44-23.61l171.2-42.78l42.78-171.1C235.2 7.406 244.7 0 256 0s20.84 7.406 23.62 18.44l42.78 171.2l171.2 42.78C504.6 235.2 512 244.6 512 255.1z" />
                                    </svg>
                                </span>
                                <span class="magic-text1">Confident and Beautiful</span>
                            </span></h1>

                    </section>
                </div>
                <div class="carousel-item">
                    <section id="commercial" >

                        <h4>The Art of Gentleman</h4>
                        <h2>Modern Men, Modern Style</h2>

                        <h1><span class="magic">
                                <span class="magic-star">
                                    <svg viewBox="0 0 512 512">
                                    <path d="M512 255.1c0 11.34-7.406 20.86-18.44 23.64l-171.3 42.78l-42.78 171.1C276.7 504.6 267.2 512 255.9 512s-20.84-7.406-23.62-18.44l-42.66-171.2L18.47 279.6C7.406 276.8 0 267.3 0 255.1c0-11.34 7.406-20.83 18.44-23.61l171.2-42.78l42.78-171.1C235.2 7.406 244.7 0 256 0s20.84 7.406 23.62 18.44l42.78 171.2l171.2 42.78C504.6 235.2 512 244.6 512 255.1z" />
                                    </svg>
                                </span>    <span class="magic-star">
                                    <svg viewBox="0 0 512 512">
                                    <path d="M512 255.1c0 11.34-7.406 20.86-18.44 23.64l-171.3 42.78l-42.78 171.1C276.7 504.6 267.2 512 255.9 512s-20.84-7.406-23.62-18.44l-42.66-171.2L18.47 279.6C7.406 276.8 0 267.3 0 255.1c0-11.34 7.406-20.83 18.44-23.61l171.2-42.78l42.78-171.1C235.2 7.406 244.7 0 256 0s20.84 7.406 23.62 18.44l42.78 171.2l171.2 42.78C504.6 235.2 512 244.6 512 255.1z" />
                                    </svg>
                                </span>    <span class="magic-star">
                                    <svg viewBox="0 0 512 512">
                                    <path d="M512 255.1c0 11.34-7.406 20.86-18.44 23.64l-171.3 42.78l-42.78 171.1C276.7 504.6 267.2 512 255.9 512s-20.84-7.406-23.62-18.44l-42.66-171.2L18.47 279.6C7.406 276.8 0 267.3 0 255.1c0-11.34 7.406-20.83 18.44-23.61l171.2-42.78l42.78-171.1C235.2 7.406 244.7 0 256 0s20.84 7.406 23.62 18.44l42.78 171.2l171.2 42.78C504.6 235.2 512 244.6 512 255.1z" />
                                    </svg>
                                </span>
                                <span class="magic-text2">Bold, Confident, Unstoppable</span>
                            </span></h1>

                    </section>
                </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>


        <!--=========Start of Feature section====================== -->
        <section id="product1" class="section-p1">
            <h2>Featured Products</h2>
            <p>Must-Have Products for Your Hair</p>
            <div class="pro-container">

                <?php
                get_products();
                ?>

        </section>

        <!-- here we will do slider -->
        <section id="GroomGallery" class="section-p1">
            <h2>Strands in Style</h2>
            <p>Unlock the Secret to Perfect Hair Days</p>
        </section>

        <section id="slider" class="sliding">
            <div id="image-track" data-mouse-down-at="0" data-prev-percentage="0">
                <img class="image" src="https://images.unsplash.com/photo-1517241938558-898c3afe02c8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=871&q=80" alt="Picture of a woman with a nice hairstyle" draggable="false" />
                <img class="image" src="https://images.unsplash.com/photo-1519699047748-de8e457a634e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80" alt="Picture of a woman with a nice hairstyle" draggable="false" />
                <img class="image" src="https://images.unsplash.com/photo-1506739882538-768415f14347?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1331&q=80" alt="Picture of a man with a nice hairstyle" draggable="false" />
                <img class="image" src="https://images.unsplash.com/photo-1589525231707-f2de2428f59c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="Picture of a woman with a nice hairstyle" draggable="false" />
                <img class="image" src="https://images.unsplash.com/photo-1565357419076-6acd4a10094e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="Picture of a woman with a nice hairstyle" draggable="false" />
                <img class="image" src="https://images.unsplash.com/photo-1456327102063-fb5054efe647?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="Picture of a man with a nice hairstyle" draggable="false" />
                <img class="image" src="https://images.unsplash.com/photo-1513906675212-4031e2ce2bb5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fH.5&auto=format&fit=crop&w=870&q=80" alt="Picture of a man with a nice hairstyle" draggable="false" />
                <img class="image" src="https://images.unsplash.com/photo-1510623040244-1f396031f3ed?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="Picture of a woman with a nice hairstyle" draggable="false" />
            </div>
        </section>


        <!-- here we will discounted products -->
        <section id="product1" class="section-p1">
            <h2>Score More, Spend Less</h2>
            <p>Make a Statement on Your First Day</p>

            <div class="pro-container">

                <?php
                get_products('random')
                ?>

        </section>

        <!-- here we will do a banner to direct users to other places -->
        <section id="sm-banner" class="section-p1">

            <div class="banner-box">
                <h4>Stock Up and Save</h4>
                <h2>HAIR50, 50% OFF</h2>
                <button class="white" onclick="showPopup()">Learn More</button>
            </div>

            <div id="popup" class="popup">
                <h2>Learn More</h2>
                <p>Looking for an unbeatable deal on your favorite products? Look no further than our exciting "HAIR50", 50% off promotion! For a limited time only, when you purchase your favorite items, you'll receive 50% off!</p>
                <button onclick="hidePopup()">Close</button>
            </div>

            <script>
                function showPopup() {
                    document.getElementById('popup').style.display = 'block';
                }

                function hidePopup() {
                    document.getElementById('popup').style.display = 'none';
                }
            </script>

            <div class="banner-box banner-box2">
                <h4>Discover Our Story</h4>
                <h2>Get to Know Us</h2>
                <button class="white" onclick="location.href = 'about.php'">About Us</button>
            </div>

            <div class="banner-box banner-box3">
                <h4>The best selection for you</h4>
                <h2>Spoiled For Choices</h2>
                <button class="white" onclick="location.href = 'shop.php'">Collection</button>
            </div>

        </section>

        <?php
        include "newsletter.inc.php";
        ?>

        <?php
        include "footer.inc.php";
        ?>


    </body>
</html>